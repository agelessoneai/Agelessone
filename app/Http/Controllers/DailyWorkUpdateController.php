<?php

namespace App\Http\Controllers;

use App\Models\DailyWorkUpdate;
use App\Models\WorkSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyWorkUpdateController extends Controller
{
    /**
     * Show the user's daily work updates and a form to post a new one.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Find work sites where this user is assigned in any role.
        $workSites = WorkSite::where(function ($query) use ($user) {
            $query->where('site_security_id', $user->id)
                ->orWhere('site_supervisor_id', $user->id)
                ->orWhere('site_manager_id', $user->id)
                ->orWhere('project_manager_id', $user->id)
                ->orWhere('project_coordinator_id', $user->id);
        })
            ->orderBy('site_name')
            ->get();

        // Get daily updates created by this user (across all sites).
        $updates = DailyWorkUpdate::with(['workSite', 'user'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('user.daily_updates.index', compact('workSites', 'updates'));
    }

    /**
     * Store a new daily work update from a user.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'work_site_id' => ['required', 'exists:work_sites,id'],
            'photo'        => ['nullable', 'image', 'max:10240'],
            'note'         => ['nullable', 'string', 'max:5000'],
            'date'         => ['required', 'date'],
        ]);

        // Ensure the user is actually assigned to the selected work site.
        $workSite = WorkSite::where('id', $validated['work_site_id'])
            ->where(function ($query) use ($user) {
                $query->where('site_security_id', $user->id)
                    ->orWhere('site_supervisor_id', $user->id)
                    ->orWhere('site_manager_id', $user->id)
                    ->orWhere('project_manager_id', $user->id)
                    ->orWhere('project_coordinator_id', $user->id);
            })
            ->first();

        abort_unless($workSite, 403, 'You are not assigned to this work site.');

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('daily-work-updates', 'public');
        }

        DailyWorkUpdate::create([
            'work_site_id' => $workSite->id,
            'user_id'      => Auth::id(),
            'photo'        => $photoPath,
            'note'         => $validated['note'] ?? null,
            'date'         => $validated['date'],
            'approval_status' => 'pending',
        ]);

        return back()->with('success', 'Daily work update posted successfully. Awaiting approval.');
    }

    /**
     * Approve a daily work update (supervisor / project manager / admin).
     */
    public function approve(Request $request, DailyWorkUpdate $dailyWorkUpdate)
    {
        $this->authorizeSupervisorOrManager($request->user(), $dailyWorkUpdate->workSite);

        $dailyWorkUpdate->update([
            'approval_status' => 'approved',
            'approved_by'     => Auth::id(),
            'approved_at'     => now(),
        ]);

        return back()->with('success', 'Daily work update approved.');
    }

    /**
     * Reject a daily work update (supervisor / project manager / admin).
     */
    public function reject(Request $request, DailyWorkUpdate $dailyWorkUpdate)
    {
        $this->authorizeSupervisorOrManager($request->user(), $dailyWorkUpdate->workSite);

        $dailyWorkUpdate->update([
            'approval_status' => 'rejected',
            'approved_by'     => Auth::id(),
            'approved_at'     => now(),
        ]);

        return back()->with('success', 'Daily work update rejected.');
    }

    /**
     * Ensure the user is a supervisor, project manager, or admin for the given work site.
     */
    private function authorizeSupervisorOrManager($user, WorkSite $workSite): void
    {
        $isAuthorized = in_array($user->role, ['admin', 'supervisor', 'site_supervisor', 'project_manager', 'project_head', 'project_coordinator', 'site_manager'])
            || $workSite->site_supervisor_id === $user->id
            || $workSite->project_manager_id === $user->id
            || $workSite->site_manager_id === $user->id
            || $workSite->project_coordinator_id === $user->id;

        abort_unless($isAuthorized, 403, 'You are not authorized to approve updates for this work site.');
    }
}
