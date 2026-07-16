<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkSite;
use Illuminate\Http\Request;

class WorkSiteController extends Controller
{
    public function index()
    {
        $sites = WorkSite::with([
            'security',
            'supervisor',
            'siteManager',
            'projectManager',
        ])
        ->latest()
        ->paginate(15);

        return view('admin.work_sites.index', compact('sites'));
    }

    public function create()
    {
        $securityUsers = User::where('role', 'site_security')
            ->orderBy('name')
            ->get();

        $supervisors = User::where('role', 'site_supervisor')
            ->orderBy('name')
            ->get();

        $siteManagers = User::where('role', 'site_manager')
            ->orderBy('name')
            ->get();

        $projectManagers = User::where('role', 'project_manager')
            ->orderBy('name')
            ->get();

        return view('admin.work_sites.create', compact(
            'securityUsers',
            'supervisors',
            'siteManagers',
            'projectManagers'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',

            'site_security_id' => 'nullable|exists:users,id',
            'site_supervisor_id' => 'nullable|exists:users,id',
            'site_manager_id' => 'nullable|exists:users,id',
            'project_manager_id' => 'nullable|exists:users,id',

            'start_date' => 'nullable|date',
            'expected_end_date' => 'nullable|date|after_or_equal:start_date',

            'status' => 'required|in:planning,active,on_hold,completed',
            'description' => 'nullable|string',
        ]);

        WorkSite::create($validated);

        return redirect()
            ->route('admin.work-sites')
            ->with('success', 'Work site created successfully.');
    }

    public function edit(WorkSite $workSite)
    {
        $securityUsers = User::where('role', 'site_security')
            ->orderBy('name')
            ->get();

        $supervisors = User::where('role', 'site_supervisor')
            ->orderBy('name')
            ->get();

        $siteManagers = User::where('role', 'site_manager')
            ->orderBy('name')
            ->get();

        $projectManagers = User::where('role', 'project_manager')
            ->orderBy('name')
            ->get();

        return view('admin.work_sites.edit', compact(
            'workSite',
            'securityUsers',
            'supervisors',
            'siteManagers',
            'projectManagers'
        ));
    }

    public function update(Request $request, WorkSite $workSite)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',

            'site_security_id' => 'nullable|exists:users,id',
            'site_supervisor_id' => 'nullable|exists:users,id',
            'site_manager_id' => 'nullable|exists:users,id',
            'project_manager_id' => 'nullable|exists:users,id',

            'start_date' => 'nullable|date',
            'expected_end_date' => 'nullable|date|after_or_equal:start_date',

            'status' => 'required|in:planning,active,on_hold,completed',
            'description' => 'nullable|string',
        ]);

        $workSite->update($validated);

        return redirect()
            ->route('admin.work-sites')
            ->with('success', 'Work site updated successfully.');
    }

    public function destroy(WorkSite $workSite)
    {
        $workSite->delete();

        return redirect()
            ->route('admin.work-sites')
            ->with('success', 'Work site deleted successfully.');
    }
}