<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\InventoryAssignmentHistory;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\VisitorEntry;
use App\Models\Worker;
use App\Models\WorkerAttendance;
use App\Models\WorkSite;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SecurityController extends Controller
{
    private function ensureSiteInventoryAccess(Request $request): void
    {
        abort_unless(
            in_array($request->user()?->role, ['admin', 'security'], true),
            403,
            'Only admin or security users can access site inventory.'
        );
    }

    private function siteFor(Request $request): ?WorkSite
    {
        $this->ensureSiteInventoryAccess($request);

        if ($request->user()->role === 'admin') {
            if ($request->filled('site_id')) {
                return WorkSite::find($request->integer('site_id'));
            }
            return WorkSite::orderBy('site_name')->first();
        }

        return WorkSite::where('site_security_id', $request->user()->id)->first();
    }

    public function dashboard(Request $request)
    {
        $site = $this->siteFor($request);

        if (!$site) {
            return view('security.no-site');
        }

        $attendance = Attendance::where(
            'user_id',
            $request->user()->id
        )
            ->whereDate('date', today())
            ->first();

        $site->load(['zones.supervisor','supervisor']);

        $workers = Worker::where(
            'work_site_id',
            $site->id
        )
            ->where('active', true)
            ->orderBy('name')
            ->get();

        $workerAttendances = WorkerAttendance::with('worker')
            ->where('work_site_id', $site->id)
            ->whereDate('attendance_date', today())
            ->get()
            ->keyBy('worker_id');

        $visitors = VisitorEntry::where(
            'work_site_id',
            $site->id
        )
            ->whereDate('check_in_at', today())
            ->latest('check_in_at')
            ->get();

        return view('security.dashboard', compact(
            'site',
            'attendance',
            'workers',
            'workerAttendances',
            'visitors'
        ));
    }



    public function inventory(Request $request)
    {
        $site = $this->siteFor($request);

        if (!$site) {
            return view('security.no-site');
        }

        $movements = InventoryMovement::with(['item.category', 'user'])
            ->where('work_site_id', $site->id)
            ->whereIn('type', ['stock_out', 'adjustment'])
            ->latest()
            ->get();

        $workers = Worker::where('work_site_id', $site->id)
            ->where('active', true)
            ->orderBy('name')
            ->get();

        $items = InventoryItem::where('active', true)
            ->orderBy('item_name')
            ->get();

        $sites = $request->user()->role === 'admin' ? WorkSite::orderBy('site_name')->get() : collect([$site]);

        return view('security.inventory', compact('site', 'sites', 'movements', 'workers', 'items'));
    }

    public function storeInventoryItem(Request $request)
    {
        $site = $this->siteFor($request);
        abort_unless($site, 403, 'No work site is assigned to this security account.');

        $data = $request->validate([
            'inventory_item_id' => ['nullable', 'exists:inventory_items,id', 'required_without:item_name'],
            'item_name' => ['nullable', 'string', 'max:255', 'required_without:inventory_item_id'],
            'item_code' => ['nullable', 'string', 'max:100'],
            'quantity' => ['required', 'integer', 'min:1'],
            'used_for' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($data, $request, $site) {
            $item = !empty($data['inventory_item_id'])
                ? InventoryItem::findOrFail($data['inventory_item_id'])
                : null;

            if (!$item) {
                $category = InventoryCategory::firstOrCreate(
                    ['name' => 'Site Items'],
                    ['code' => 'SITE-ITEMS', 'description' => 'Items added directly by site security.', 'active' => true]
                );

                $baseCode = $data['item_code'] ?: 'SITE-'.strtoupper(Str::random(6));
                $code = $baseCode;
                $i = 1;
                while (InventoryItem::where('item_code', $code)->exists()) {
                    $code = $baseCode.'-'.$i++;
                }

                $item = InventoryItem::create([
                    'inventory_category_id' => $category->id,
                    'item_name' => $data['item_name'],
                    'item_code' => $code,
                    'warehouse' => $site->site_name,
                    'stock' => 0,
                    'minimum_stock' => 0,
                    'maximum_stock' => max(1, (int) $data['quantity']),
                    'unit' => 'PCS',
                    'usage_purpose' => $data['used_for'] ?? null,
                    'inventory_type' => 'site',
                    'active' => true,
                ]);
            }

            InventoryMovement::create([
                'inventory_item_id' => $item->id,
                'user_id' => $request->user()->id,
                'work_site_id' => $site->id,
                'type' => 'adjustment',
                'quantity' => $data['quantity'],
                'previous_stock' => 0,
                'new_stock' => 0,
                'warehouse' => $site->site_name,
                'used_for' => $data['used_for'] ?? $item->usage_purpose,
                'issued_to' => null,
                'assignment_status' => 'available',
                'note' => $data['note'] ?? 'Added directly by site security.',
            ]);
        });

        return back()->with('success', 'Item added to site inventory.');
    }

    public function assignInventoryItem(Request $request, InventoryMovement $inventoryMovement)
    {
        $site = $this->siteFor($request);
        abort_unless($site && (int) $inventoryMovement->work_site_id === (int) $site->id, 403);

        $data = $request->validate([
            'worker_id' => ['nullable', 'exists:workers,id'],
            'assigned_to' => ['nullable', 'string', 'max:255', 'required_without:worker_id'],
            'used_for' => ['nullable', 'string', 'max:255'],
        ]);

        $assignedTo = $data['assigned_to'] ?? null;
        if (!empty($data['worker_id'])) {
            $worker = Worker::where('work_site_id', $site->id)->findOrFail($data['worker_id']);
            $assignedTo = $worker->name.' ('.$worker->worker_code.')';
        }

        DB::transaction(function () use ($inventoryMovement, $assignedTo, $data, $request) {
            $assignedAt = now();
            $purpose = $data['used_for'] ?? $inventoryMovement->used_for;

            $inventoryMovement->update([
                'issued_to' => $assignedTo,
                'used_for' => $purpose,
                'assignment_status' => 'using',
                'assigned_at' => $assignedAt,
                'returned_at' => null,
                'returned_by_user_id' => null,
                'return_condition' => null,
                'return_note' => null,
                'note' => trim(($inventoryMovement->note ? $inventoryMovement->note."\n" : '').'Assigned by security on '.$assignedAt->format('d M Y h:i A').'.'),
            ]);

            InventoryAssignmentHistory::create([
                'inventory_movement_id' => $inventoryMovement->id,
                'assigned_to' => $assignedTo,
                'used_for' => $purpose,
                'assigned_by_user_id' => $request->user()->id,
                'assigned_at' => $assignedAt,
            ]);
        });

        return back()->with('success', 'Item marked as in use by '.$assignedTo.'.');
    }

    public function returnInventoryItem(Request $request, InventoryMovement $inventoryMovement)
    {
        $site = $this->siteFor($request);
        abort_unless($site && (int) $inventoryMovement->work_site_id === (int) $site->id, 403);

        $data = $request->validate([
            'return_condition' => ['nullable', Rule::in(['good', 'damaged', 'repair'])],
            'return_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $previousUser = $inventoryMovement->issued_to ?: 'user';

        DB::transaction(function () use ($inventoryMovement, $previousUser, $data, $request) {
            $returnedAt = now();

            $inventoryMovement->update([
                'issued_to' => null,
                'assignment_status' => 'returned',
                'returned_at' => $returnedAt,
                'returned_by_user_id' => $request->user()->id,
                'return_condition' => $data['return_condition'] ?? 'good',
                'return_note' => $data['return_note'] ?? null,
                'note' => trim(($inventoryMovement->note ? $inventoryMovement->note."\n" : '').'Returned from '.$previousUser.' on '.$returnedAt->format('d M Y h:i A').'.'),
            ]);

            $history = $inventoryMovement->assignmentHistories()
                ->whereNull('returned_at')
                ->latest('assigned_at')
                ->first();

            if ($history) {
                $history->update([
                    'returned_by_user_id' => $request->user()->id,
                    'returned_at' => $returnedAt,
                    'return_condition' => $data['return_condition'] ?? 'good',
                    'return_note' => $data['return_note'] ?? null,
                ]);
            }
        });

        return back()->with('success', 'Item marked as returned and available.');
    }

    public function history(Request $request)
    {
        $site = $this->siteFor($request);

        if (!$site) {
            return view('security.no-site');
        }

        $workerAttendances = WorkerAttendance::with([
            'worker', 'siteZone', 'supervisor', 'recordedBy',
        ])
            ->where('work_site_id', $site->id)
            ->latest('attendance_date')
            ->latest('id')
            ->paginate(20, ['*'], 'workers');

        $visitors = VisitorEntry::with('recordedBy')
            ->where('work_site_id', $site->id)
            ->latest('check_in_at')
            ->paginate(20, ['*'], 'visitors');

        return view('security.history', compact(
            'site', 'workerAttendances', 'visitors'
        ));
    }

    public function storeWorker(Request $request)
    {
        $site = $this->siteFor($request);

        if (!$site) {
            return back()->withErrors([
                'site' => 'No work site is assigned to this security account.',
            ]);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['required', 'image', 'max:4096'],
        ]);

        $data['photo'] = $request->file('photo')
            ->store('workers/photos', 'public');
        $data['work_site_id'] = $site->id;
        $data['worker_code'] = $this->nextWorkerCode($site);
        $data['trade'] = 'General';
        $data['role'] = 'worker';
        $data['active'] = true;

        Worker::create($data);

        return back()->with('success', 'Worker added to '.$site->site_name.'.');
    }

    private function nextWorkerCode(WorkSite $site): string
    {
        $number = Worker::where('work_site_id', $site->id)->count() + 1;

        do {
            $code = 'W-'.str_pad((string) $number, 4, '0', STR_PAD_LEFT);
            $number++;
        } while (Worker::where('work_site_id', $site->id)
            ->where('worker_code', $code)
            ->exists());

        return $code;
    }

    public function storeVisitor(Request $request)
    {
        $site = $this->siteFor($request);

        if (!$site) {
            return back()->withErrors([
                'site' => 'No work site is assigned to this security account.',
            ]);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:30'],
            'photo' => ['required', 'image', 'max:5120'],
        ]);

        $data['photo'] = $request
            ->file('photo')
            ->store('security/visitors', 'public');

        $data['work_site_id'] = $site->id;
        $data['recorded_by'] = $request->user()->id;
        $data['check_in_at'] = now();

        VisitorEntry::create($data);

        return back()->with(
            'success',
            'Visitor check-in recorded.'
        );
    }

    public function visitorCheckout(
        Request $request,
        VisitorEntry $visitor
    ) {
        $site = $this->siteFor($request);

        abort_unless(
            $site && $visitor->work_site_id === $site->id,
            403
        );

        $visitor->update([
            'check_out_at' => now(),
        ]);

        return back()->with(
            'success',
            'Visitor check-out recorded.'
        );
    }

    public function workerPunchIn(
        Request $request,
        Worker $worker
    ) {
        $site = $this->siteFor($request);

        abort_unless(
            $site
            && $worker->work_site_id === $site->id
            && $worker->active,
            403
        );

        $photo = $worker->photo;

        $existingRecord = WorkerAttendance::where(
            'worker_id',
            $worker->id
        )
            ->whereDate('attendance_date', today())
            ->first();

        if ($existingRecord && $existingRecord->punch_in) {
            return back()->withErrors([
                'attendance' => $worker->name
                    .' has already punched in today.',
            ]);
        }

        WorkerAttendance::updateOrCreate(
            [
                'worker_id' => $worker->id,
                'attendance_date' => today()->toDateString(),
            ],
            [
                'work_site_id' => $site->id,
                'recorded_by' => $request->user()->id,
                'site_zone_id' => null,
                'supervisor_id' => $site->site_supervisor_id,
                'work_description' => 'General work',
                'punch_in' => now()->format('H:i:s'),
                'punch_in_photo' => $photo,
                'status' => 'pending',
            ]
        );

        return back()->with(
            'success',
            $worker->name.' punched in.'
        );
    }

    public function workerPunchOut(
        Request $request,
        Worker $worker
    ) {
        $site = $this->siteFor($request);

        abort_unless(
            $site && $worker->work_site_id === $site->id,
            403
        );

        $record = WorkerAttendance::where(
            'worker_id',
            $worker->id
        )
            ->whereDate('attendance_date', today())
            ->first();

        if (!$record || !$record->punch_in) {
            return back()->withErrors([
                'attendance' => 'Punch in must be completed first.',
            ]);
        }

        if ($record->punch_out) {
            return back()->withErrors([
                'attendance' => $worker->name
                    .' has already punched out today.',
            ]);
        }

        $photo = $worker->photo;

        $out = now();

        $punchIn = \Carbon\Carbon::parse(
            today()->toDateString().' '.$record->punch_in
        );

        $record->update([
            'punch_out' => $out->format('H:i:s'),
            'punch_out_photo' => $photo,
            'working_minutes' => $punchIn->diffInMinutes($out),
        ]);

        return back()->with(
            'success',
            $worker->name.' punched out.'
        );
    }

    public function adminIndex()
    {
        return view('admin.security-activity', [
            'visitors' => VisitorEntry::with([
                'workSite',
                'recordedBy',
            ])
                ->latest('check_in_at')
                ->paginate(15, ['*'], 'visitors'),

            'workerAttendances' => WorkerAttendance::with([
                'worker',
                'workSite',
                'recordedBy',
                'siteZone',
                'supervisor',
            ])
                ->latest('attendance_date')
                ->paginate(15, ['*'], 'workers'),
        ]);
    }
}