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
            'projectCoordinator',
        ])
        ->latest()
        ->paginate(15);

        return view('admin.work_sites.index', compact('sites'));
    }


    public function show(WorkSite $workSite)
    {
        $workSite->load([
            'security', 'supervisor', 'siteManager', 'projectManager', 'projectCoordinator',
            'projectCoordinator',
            'zones.workerAssignments.worker', 'workerAssignments.worker', 'workers',
            'inventoryMovements.item.category', 'inventoryMovements.user',
            'workerAttendances.worker', 'workerAttendances.recordedBy', 'workerAttendances.approvedBy', 'workerAttendances.workSessions.siteZone',
            'attendances.user', 'visitors.recordedBy',
        ]);

        $allWorkerAssignments = $workSite->workerAssignments;
        $totalWorkers = $workSite->workers->count();
        $siteProgress = (int) round($workSite->zones->avg('progress') ?? 0);
        $securityAttendance = $workSite->attendances->where('user_id', $workSite->site_security_id)->sortByDesc('date');
        $supervisorAttendance = $workSite->attendances->where('user_id', $workSite->site_supervisor_id)->sortByDesc('date');
        $pendingAttendanceCount = $workSite->workerAttendances->where('status', 'pending')->count();
        $activeWorkerAttendances = $workSite->workerAttendances->whereNull('punch_out')->sortByDesc('attendance_date');
        $approvedWorkerAttendances = $workSite->workerAttendances->where('status', 'approved')->sortByDesc('attendance_date');
        $pendingWorkerAttendances = $workSite->workerAttendances->where('status', 'pending')->sortByDesc('attendance_date');
        $siteVisitors = $workSite->visitors->sortByDesc('check_in_at');

        $siteInventory = $workSite->inventoryMovements
            ->whereIn('type', ['stock_out', 'adjustment'])
            ->sortByDesc('created_at');

        return view('admin.work_sites.show', compact(
            'workSite', 'allWorkerAssignments', 'totalWorkers', 'siteProgress', 'siteInventory',
            'securityAttendance', 'supervisorAttendance', 'pendingAttendanceCount', 'activeWorkerAttendances',
            'approvedWorkerAttendances', 'pendingWorkerAttendances', 'siteVisitors'
        ));
    }

    public function inventory(WorkSite $workSite)
    {
        $movements = $workSite->inventoryMovements()
            ->with(['item.category', 'user', 'returnedBy', 'assignmentHistories.assignedBy', 'assignmentHistories.returnedBy'])
            ->whereIn('type', ['stock_out', 'adjustment'])
            ->latest()
            ->paginate(25);

        $totalQuantity = (int) $workSite->inventoryMovements()
            ->whereIn('type', ['stock_out', 'adjustment'])
            ->sum('quantity');

        $totalItemTypes = $workSite->inventoryMovements()
            ->whereIn('type', ['stock_out', 'adjustment'])
            ->distinct('inventory_item_id')
            ->count('inventory_item_id');

        return view('admin.work_sites.inventory', compact(
            'workSite', 'movements', 'totalQuantity', 'totalItemTypes'
        ));
    }

    public function create()
    {
        $securityUsers = User::where('role', 'security')
            ->where(function ($query) {
                $query->where('status', 'active')->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        $supervisors = User::whereIn('role', ['site_supervisor', 'supervisor'])
            ->where(function ($query) {
                $query->where('status', 'active')->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        $siteManagers = User::whereIn('role', ['site_manager', 'project_manager'])
            ->where(function ($query) {
                $query->where('status', 'active')->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        $projectManagers = User::where('role', 'project_manager')
            ->where(function ($query) {
                $query->where('status', 'active')->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        $projectCoordinators = User::whereIn('role', ['project_coordinator', 'project_head'])
            ->where(function ($query) {
                $query->where('status', 'active')->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        return view('admin.work_sites.create', compact(
            'securityUsers',
            'supervisors',
            'siteManagers',
            'projectManagers',
            'projectCoordinators'
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
            'project_coordinator_id' => 'nullable|exists:users,id',

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
        $securityUsers = User::where('role', 'security')
            ->where(function ($query) {
                $query->where('status', 'active')->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        $supervisors = User::whereIn('role', ['site_supervisor', 'supervisor'])
            ->where(function ($query) {
                $query->where('status', 'active')->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        $siteManagers = User::whereIn('role', ['site_manager', 'project_manager'])
            ->where(function ($query) {
                $query->where('status', 'active')->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        $projectManagers = User::where('role', 'project_manager')
            ->where(function ($query) {
                $query->where('status', 'active')->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        $projectCoordinators = User::whereIn('role', ['project_coordinator', 'project_head'])
            ->where(function ($query) {
                $query->where('status', 'active')->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        return view('admin.work_sites.edit', compact(
            'workSite',
            'securityUsers',
            'supervisors',
            'siteManagers',
            'projectManagers',
            'projectCoordinators'
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
            'project_coordinator_id' => 'nullable|exists:users,id',

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