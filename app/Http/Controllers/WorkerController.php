<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\WorkSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class WorkerController extends Controller
{
    public function index(Request $request, WorkSite $workSite)
    {
        $query = $workSite->workers();

        $query->when($request->search, function ($builder, $search) {
            $builder->where(function ($q) use ($search) {
                $q->where('worker_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('trade', 'like', "%{$search}%");
            });
        })->when($request->role, fn ($q, $role) => $q->where('role', $role));

        $workers = $query->latest()->paginate(15)->withQueryString();

        return view('admin.workers.index', compact('workSite', 'workers'))
            ->with('roles', Worker::roles());
    }


    public function bulkCreate(WorkSite $workSite)
    {
        return view('admin.workers.bulk-create', compact('workSite'))
            ->with('roles', Worker::roles());
    }

    public function bulkStore(Request $request, WorkSite $workSite)
    {
        $data = $request->validate([
            'workers' => ['required','array','min:1'],
            'workers.*.worker_code' => ['required','string','max:100','distinct'],
            'workers.*.name' => ['required','string','max:255'],
            'workers.*.mobile' => ['nullable','string','max:30'],
            'workers.*.trade' => ['required','string','max:100'],
            'workers.*.role' => ['required', Rule::in(array_keys(Worker::roles()))],
        ]);

        foreach ($data['workers'] as $row) {
            validator($row, [
                'worker_code' => [Rule::unique('workers')->where(
                    fn ($query) => $query->where('work_site_id', $workSite->id)
                )],
            ])->validate();
            Worker::create([
                'work_site_id' => $workSite->id,
                'worker_code' => $row['worker_code'],
                'name' => $row['name'],
                'mobile' => $row['mobile'] ?? null,
                'trade' => $row['trade'],
                'role' => $row['role'],
                'active' => true,
            ]);
        }

        return redirect()->route('admin.work-sites.workers.index', $workSite)
            ->with('success', count($data['workers']).' workers added successfully.');
    }

    public function create(WorkSite $workSite)
    {
        return view('admin.workers.create', compact('workSite'))
            ->with('roles', Worker::roles());
    }

    public function store(Request $request, WorkSite $workSite)
    {
        $validated = $this->validateWorker($request);
        $validated['work_site_id'] = $workSite->id;
        $validated['active'] = $request->boolean('active');
        $this->storeFiles($request, $validated);
        Worker::create($validated);

        return redirect()->route('admin.work-sites.workers.index', $workSite)
            ->with('success', 'Site worker added successfully.');
    }

    public function edit(WorkSite $workSite, Worker $worker)
    {
        abort_unless($worker->work_site_id === $workSite->id, 404);
        return view('admin.workers.edit', compact('workSite', 'worker'))
            ->with('roles', Worker::roles());
    }

    public function update(Request $request, WorkSite $workSite, Worker $worker)
    {
        abort_unless($worker->work_site_id === $workSite->id, 404);
        $validated = $this->validateWorker($request, $worker);
        $validated['active'] = $request->boolean('active');
        $this->storeFiles($request, $validated, $worker);
        $worker->update($validated);

        return redirect()->route('admin.work-sites.workers.index', $workSite)
            ->with('success', 'Site worker updated successfully.');
    }

    public function destroy(WorkSite $workSite, Worker $worker)
    {
        abort_unless($worker->work_site_id === $workSite->id, 404);
        if ($worker->photo) Storage::disk('public')->delete($worker->photo);
        if ($worker->id_proof) Storage::disk('public')->delete($worker->id_proof);
        $worker->delete();

        return back()->with('success', 'Site worker deleted successfully.');
    }

    private function validateWorker(Request $request, ?Worker $worker = null): array
    {
        return $request->validate([
            'worker_code' => [
                'required','string','max:100',
                Rule::unique('workers')->where(
                    fn ($query) => $query->where(
                        'work_site_id',
                        $worker?->work_site_id ?? $request->route('workSite')?->id
                    )
                )->ignore($worker?->id),
            ],
            'name' => ['required','string','max:255'],
            'role' => ['required', Rule::in(array_keys(Worker::roles()))],
            'photo' => ['nullable','image','max:4096'],
            'mobile' => ['nullable','string','max:30'],
            'aadhaar_number' => ['nullable','string','max:20'],
            'id_proof' => ['nullable','file','max:5120'],
            'trade' => ['required','string','max:100'],
            'skill_level' => ['nullable','string','max:100'],
            'contractor_name' => ['nullable','string','max:255'],
            'daily_wage' => ['nullable','numeric','min:0'],
            'hourly_rate' => ['nullable','numeric','min:0'],
            'overtime_rate' => ['nullable','numeric','min:0'],
            'blood_group' => ['nullable','string','max:20'],
            'emergency_contact' => ['nullable','string','max:30'],
            'address' => ['nullable','string'],
            'active' => ['nullable','boolean'],
        ]);
    }

    private function storeFiles(Request $request, array &$validated, ?Worker $worker = null): void
    {
        if ($request->hasFile('photo')) {
            if ($worker?->photo) Storage::disk('public')->delete($worker->photo);
            $validated['photo'] = $request->file('photo')->store('workers/photos', 'public');
        }
        if ($request->hasFile('id_proof')) {
            if ($worker?->id_proof) Storage::disk('public')->delete($worker->id_proof);
            $validated['id_proof'] = $request->file('id_proof')->store('workers/id-proofs', 'public');
        }
    }
}
