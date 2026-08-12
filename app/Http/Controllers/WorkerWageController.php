<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\WorkerWage;
use App\Models\WorkSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class WorkerWageController extends Controller
{
    /**
     * List all wage records across all work sites (admin sidebar entry).
     */
    public function globalIndex(Request $request)
    {
        $workSites = WorkSite::orderBy('site_name')->get();

        $query = WorkerWage::with(['worker', 'workSite', 'recordedBy']);

        if ($request->filled('work_site_id')) {
            $query->where('work_site_id', $request->work_site_id);
        }

        if ($request->filled('worker_id')) {
            $query->where('worker_id', $request->worker_id);
        }

        if ($request->filled('month')) {
            $query->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$request->month]);
        }

        $wages = $query->orderByDesc('date')->paginate(20)->withQueryString();

        $totalWage = (clone $query)->sum('total_wage');

        $selectedSite = $request->filled('work_site_id') ? WorkSite::find($request->work_site_id) : null;
        $workers = $selectedSite
            ? $selectedSite->workers()->orderBy('name')->get()
            : Worker::orderBy('name')->get();

        return view('admin.wages.global-index', compact('workSites', 'workers', 'wages', 'totalWage', 'selectedSite'));
    }

    /**
     * List all wage records for a given work site (admin).
     */
    public function index(Request $request, WorkSite $workSite)
    {
        $workers = $workSite->workers()->orderBy('name')->get();

        $query = WorkerWage::with(['worker', 'recordedBy'])
            ->where('work_site_id', $workSite->id);

        if ($request->filled('worker_id')) {
            $query->where('worker_id', $request->worker_id);
        }

        if ($request->filled('month')) {
            $query->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$request->month]);
        }

        $wages = $query->orderByDesc('date')->paginate(20)->withQueryString();

        $totalWage = (clone $query)->sum('total_wage');

        return view('admin.wages.index', compact('workSite', 'workers', 'wages', 'totalWage'));
    }

    /**
     * Show form to add a wage entry without specific work site (admin).
     */
    public function globalCreate()
    {
        $workSites = WorkSite::orderBy('site_name')->get();
        // Get all active workers grouped by work_site_id
        $workers = Worker::where('active', true)->orderBy('name')->get();
        return view('admin.wages.global-create', compact('workSites', 'workers'));
    }

    /**
     * Store wage entry without specific work site in URL (admin).
     */
    public function globalStore(Request $request)
    {
        $validated = $request->validate([
            'work_site_id' => ['required', 'exists:work_sites,id']
        ]);
        $workSite = WorkSite::findOrFail($validated['work_site_id']);
        return $this->saveWage($request, $workSite, route('admin.wages.index'));
    }

    /**
     * Show form to add a wage entry (admin).
     */
    public function create(WorkSite $workSite)
    {
        $workers = $workSite->workers()->where('active', true)->orderBy('name')->get();
        return view('admin.wages.create', compact('workSite', 'workers'));
    }

    /**
     * Store wage entry (admin).
     */
    public function store(Request $request, WorkSite $workSite)
    {
        return $this->saveWage($request, $workSite);
    }

    /**
     * Supervisor: Show form to add a wage entry.
     */
    public function supervisorCreate(Request $request)
    {
        $user = auth()->user();

        // Find work site the user is assigned to
        $workSite = WorkSite::where('site_supervisor_id', $user->id)
            ->orWhere('site_manager_id', $user->id)
            ->orWhere('project_manager_id', $user->id)
            ->orWhere('project_coordinator_id', $user->id)
            ->orWhere('project_head_id', $user->id)
            ->orWhere('work_coordinator_id', $user->id)
            ->first();

        // If no direct site assignment, send admin/managers to global wage form
        if (!$workSite) {
            if (Route::has('admin.wages.create') && in_array($user->role, ['admin','project_manager','project_coordinator','project_head','site_manager'])) {
                return redirect()->route('admin.wages.create')->with('info', 'Please select a work site and worker.');
            }
            return back()->with('error', 'You are not assigned to any work site. Please contact your administrator.');
        }

        $workers = $workSite->workers()->where('active', true)->orderBy('name')->get();
        $recentWages = WorkerWage::with('worker')
            ->where('work_site_id', $workSite->id)
            ->whereDate('created_at', today())
            ->orderByDesc('id')
            ->get();

        return view('supervisor.wages.create', compact('workSite', 'workers', 'recentWages'));
    }

    /**
     * Supervisor: Store wage entry.
     */
    public function supervisorStore(Request $request)
    {
        $user = auth()->user();

        $workSite = WorkSite::where('site_supervisor_id', $user->id)
            ->orWhere('site_manager_id', $user->id)
            ->first();

        if (!$workSite) {
            return back()->with('error', 'You are not assigned to any work site.');
        }

        return $this->saveWage($request, $workSite);
    }

    /**
     * Supervisor: Show form to edit a wage entry.
     */
    public function supervisorEdit(WorkerWage $wage)
    {
        $user = auth()->user();
        $isManager = in_array($user->id, [
            $wage->workSite->site_supervisor_id,
            $wage->workSite->site_manager_id,
            $wage->workSite->project_manager_id,
            $wage->workSite->project_coordinator_id,
            $wage->workSite->project_head_id
        ]);
        abort_unless($wage->recorded_by === $user->id || $isManager, 403);
        
        $wage->load('worker');
        return view('supervisor.wages.edit', compact('wage'));
    }

    /**
     * Supervisor: Update wage entry.
     */
    public function supervisorUpdate(Request $request, WorkerWage $wage)
    {
        $user = auth()->user();
        $isManager = in_array($user->id, [
            $wage->workSite->site_supervisor_id,
            $wage->workSite->site_manager_id,
            $wage->workSite->project_manager_id,
            $wage->workSite->project_coordinator_id,
            $wage->workSite->project_head_id
        ]);
        abort_unless($wage->recorded_by === $user->id || $isManager, 403);
        
        return $this->updateWageLogic($request, $wage, route('supervisor.wages.create'));
    }

    /**
     * Supervisor: Delete a wage entry.
     */
    public function supervisorDestroy(WorkerWage $wage)
    {
        $user = auth()->user();
        $isManager = in_array($user->id, [
            $wage->workSite->site_supervisor_id,
            $wage->workSite->site_manager_id,
            $wage->workSite->project_manager_id,
            $wage->workSite->project_coordinator_id,
            $wage->workSite->project_head_id
        ]);
        abort_unless($wage->recorded_by === $user->id || $isManager, 403);
        
        $wage->delete();
        return back()->with('success', 'Wage record deleted successfully.');
    }

    /**
     * Show form to edit a wage entry (admin).
     */
    public function edit(WorkerWage $wage)
    {
        $wage->load(['worker', 'workSite']);
        return view('admin.wages.edit', compact('wage'));
    }

    /**
     * Update a wage entry (admin).
     */
    public function update(Request $request, WorkerWage $wage)
    {
        return $this->updateWageLogic($request, $wage, route('admin.wages.index'));
    }

    private function updateWageLogic(Request $request, WorkerWage $wage, string $redirectRoute)
    {
        $validated = $request->validate([
            'date'          => ['required', 'date'],
            'hours_worked'  => ['required', 'numeric', 'min:0', 'max:24'],
            'base_wage'     => ['required', 'numeric', 'min:0'],
            'overtime_rate' => ['required', 'numeric', 'min:0'],
            'notes'         => ['nullable', 'string', 'max:500'],
        ]);

        $worker = $wage->worker;
        $standardHours = $worker->standard_hours ?? 8;

        $hoursWorked   = (float) $validated['hours_worked'];
        $overtimeHours = max(0, $hoursWorked - $standardHours);

        $baseWage     = (float) $validated['base_wage'];
        $overtimeRate = (float) $validated['overtime_rate'];
        $overtimePay  = round($overtimeHours * $overtimeRate, 2);
        $totalWage    = round($baseWage + $overtimePay, 2);

        if ($worker->daily_wage == 0 && $baseWage > 0) {
            $worker->update(['daily_wage' => $baseWage]);
        }
        if ($worker->overtime_rate == 0 && $overtimeRate > 0) {
            $worker->update(['overtime_rate' => $overtimeRate]);
        }

        $wage->update([
            'date'          => $validated['date'],
            'hours_worked'  => $hoursWorked,
            'overtime_hours'=> $overtimeHours,
            'base_wage'     => $baseWage,
            'overtime_rate' => $overtimeRate,
            'overtime_pay'  => $overtimePay,
            'total_wage'    => $totalWage,
            'notes'         => $validated['notes'] ?? null,
        ]);

        return redirect($redirectRoute)
            ->with('success', 'Wage entry updated successfully. Total: ₹' . number_format($totalWage, 2));
    }

    /**
     * Delete a wage entry (admin).
     */
    public function destroy(WorkerWage $wage)
    {
        $wage->delete();
        return back()->with('success', 'Wage record deleted successfully.');
    }

    /**
     * Shared wage saving logic.
     */
    private function saveWage(Request $request, WorkSite $workSite, string $redirectRoute = null)
    {
        $validated = $request->validate([
            'worker_id'     => ['required', 'exists:workers,id'],
            'date'          => ['required', 'date'],
            'hours_worked'  => ['required', 'numeric', 'min:0', 'max:24'],
            'base_wage'     => ['nullable', 'numeric', 'min:0'],
            'overtime_rate' => ['nullable', 'numeric', 'min:0'],
            'notes'         => ['nullable', 'string', 'max:500'],
        ]);

        $worker = Worker::findOrFail($validated['worker_id']);

        // Ensure worker belongs to this site
        abort_unless($worker->work_site_id === $workSite->id, 403);

        $standardHours = $worker->standard_hours ?? 8;
        $hoursWorked   = (float) $validated['hours_worked'];
        $overtimeHours = max(0, $hoursWorked - $standardHours);

        $baseWage     = isset($validated['base_wage']) && $validated['base_wage'] !== ''
            ? (float) $validated['base_wage']
            : (float) ($worker->daily_wage ?? 0);

        $overtimeRate = isset($validated['overtime_rate']) && $validated['overtime_rate'] !== ''
            ? (float) $validated['overtime_rate']
            : (float) ($worker->overtime_rate ?? 0);

        $overtimePay  = round($overtimeHours * $overtimeRate, 2);
        $totalWage    = round($baseWage + $overtimePay, 2);

        // Update worker's rates if provided and worker rate was 0
        if ($worker->daily_wage == 0 && $baseWage > 0) {
            $worker->update(['daily_wage' => $baseWage]);
        }
        if ($worker->overtime_rate == 0 && $overtimeRate > 0) {
            $worker->update(['overtime_rate' => $overtimeRate]);
        }

        WorkerWage::create([
            'worker_id'     => $worker->id,
            'work_site_id'  => $workSite->id,
            'date'          => $validated['date'],
            'hours_worked'  => $hoursWorked,
            'overtime_hours'=> $overtimeHours,
            'base_wage'     => $baseWage,
            'overtime_rate' => $overtimeRate,
            'overtime_pay'  => $overtimePay,
            'total_wage'    => $totalWage,
            'notes'         => $validated['notes'] ?? null,
            'recorded_by'   => auth()->id(),
        ]);

        if ($redirectRoute) {
            $route = $redirectRoute;
        } else {
            $route = auth()->user()->role === 'admin'
                ? route('admin.work-sites.wages.index', $workSite)
                : route('supervisor.wages.create');
        }

        return redirect($route)->with('success', 'Wage entry saved. Total: ₹' . number_format($totalWage, 2));
    }
}
