<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AdminNotification;
use App\Models\WorkSite;
use App\Models\WorkerAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PhotoVerificationService;

class AttendanceController extends Controller
{
    private function assignedSite(Request $request): ?WorkSite
    {
        $user = $request->user();
        if (!$user) return null;

        return match ($user->role) {
            'security' => WorkSite::where('site_security_id', $user->id)->first(),
            'site_supervisor' => WorkSite::where('site_supervisor_id', $user->id)->first(),
            'site_manager' => WorkSite::where('site_manager_id', $user->id)->first(),
            'project_manager' => WorkSite::where('project_manager_id', $user->id)->first(),
            'project_coordinator' => WorkSite::where('project_coordinator_id', $user->id)->first(),
            default => null,
        };
    }

    public function punchIn(Request $request)
    {
        $requiresPhoto = in_array($request->user()->role, ['security', 'site_supervisor'], true);
        $request->validate([
            'photo' => [$requiresPhoto ? 'required' : 'nullable', 'file', 'max:12288', 'mimetypes:image/jpeg,image/jpg,image/png,image/webp,image/heic,image/heif,image/heic-sequence,image/heif-sequence'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $existing = Attendance::where('user_id', Auth::id())->whereDate('date', today())->first();
        if ($existing?->punch_in) return back()->withErrors(['attendance' => 'You have already punched in today.']);

        $site = $this->assignedSite($request);
        $photo = $request->hasFile('photo') ? $request->file('photo')->store('attendance/staff/punch-in', 'public') : null;
        $verification = app(PhotoVerificationService::class)->compare($request->user()->photo, $photo);

        $attendance = Attendance::updateOrCreate(
            ['user_id' => Auth::id(), 'date' => today()->toDateString()],
            [
                'work_site_id' => $site?->id,
                'punch_in' => now(),
                'punch_in_photo' => $photo,
                'punch_in_verification_status' => $verification['status'],
                'punch_in_match_score' => $verification['score'],
                'punch_in_verification_note' => $verification['reason'],
                'status' => 'present',
                'location' => $request->location ?: $site?->site_name,
            ]
        );

        $this->notifyAdminWhenPhotoNeedsReview($attendance, 'Punch In', $verification, $site?->site_name);

        $message = $verification['status'] === 'matched'
            ? 'Punch In recorded successfully. Photo verified.'
            : 'Punch In saved successfully. Photo did not verify automatically; Admin has been notified.';

        return back()->with('success', $message);
    }

    public function punchOut(Request $request)
    {
        $requiresPhoto = in_array($request->user()->role, ['security', 'site_supervisor'], true);
        $request->validate([
            'photo' => [$requiresPhoto ? 'required' : 'nullable', 'file', 'max:12288', 'mimetypes:image/jpeg,image/jpg,image/png,image/webp,image/heic,image/heif,image/heic-sequence,image/heif-sequence'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $attendance = Attendance::where('user_id', Auth::id())->whereDate('date', today())->first();
        if (!$attendance?->punch_in) return back()->withErrors(['attendance' => 'Punch In must be completed first.']);
        if ($attendance->punch_out) return back()->withErrors(['attendance' => 'You have already punched out today.']);

        $photo = $request->hasFile('photo') ? $request->file('photo')->store('attendance/staff/punch-out', 'public') : null;
        $verification = app(PhotoVerificationService::class)->compare($request->user()->photo, $photo);

        $attendance->punch_out = now();
        $attendance->punch_out_photo = $photo;
        $attendance->punch_out_verification_status = $verification['status'];
        $attendance->punch_out_match_score = $verification['score'];
        $attendance->punch_out_verification_note = $verification['reason'];
        $attendance->punch_out_location = $request->location;
        $attendance->total_minutes = Carbon::parse($attendance->punch_in)->diffInMinutes(now());
        $attendance->save();

        $this->notifyAdminWhenPhotoNeedsReview($attendance, 'Punch Out', $verification, $attendance->workSite?->site_name);

        $message = $verification['status'] === 'matched'
            ? 'Punch Out recorded successfully. Photo verified.'
            : 'Punch Out saved successfully. Photo did not verify automatically; Admin has been notified.';

        return back()->with('success', $message);
    }

    private function notifyAdminWhenPhotoNeedsReview(Attendance $attendance, string $action, array $verification, ?string $siteName): void
    {
        if ($verification['status'] === 'matched') return;

        $user = $attendance->user()->first();
        $scoreText = $verification['score'] !== null ? ' Match score: '.$verification['score'].'%.' : '';

        AdminNotification::create([
            'type' => 'attendance_photo_alert',
            'title' => $action.' photo verification alert',
            'message' => ($user?->display_name ?? 'Staff').' completed '.$action.' at '.($siteName ?: 'unassigned site').'. Attendance was saved, but the photo requires Admin review.'.$scoreText,
            'user_id' => $attendance->user_id,
            'attendance_id' => $attendance->id,
            'data' => [
                'action' => $action,
                'verification_status' => $verification['status'],
                'match_score' => $verification['score'],
                'reason' => $verification['reason'],
            ],
        ]);
    }

    public function adminIndex()
    {
        $attendances = Attendance::with(['user', 'workSite'])
            ->latest('date')
            ->latest('punch_in')
            ->paginate(15, ['*'], 'staff_page');

        $pendingWorkerAttendances = WorkerAttendance::with([
                'worker', 'workSite', 'siteZone', 'recordedBy', 'supervisor',
            ])
            ->where('status', 'pending')
            ->latest('attendance_date')
            ->latest('id')
            ->paginate(15, ['*'], 'worker_page');

        $photoAlerts = AdminNotification::with(['user', 'attendance'])
            ->where('type', 'attendance_photo_alert')
            ->latest()
            ->limit(30)
            ->get();

        return view('admin.attendance', compact('attendances', 'pendingWorkerAttendances', 'photoAlerts'));
    }

    public function adminApproveWorkerAttendance(Request $request, WorkerAttendance $workerAttendance)
    {
        abort_unless($workerAttendance->status === 'pending', 422, 'This attendance has already been reviewed.');

        $workerAttendance->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Worker attendance approved by Admin.');
    }

    public function adminRejectWorkerAttendance(Request $request, WorkerAttendance $workerAttendance)
    {
        abort_unless($workerAttendance->status === 'pending', 422, 'This attendance has already been reviewed.');

        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $workerAttendance->update([
            'status' => 'rejected',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
            'rejection_reason' => $data['rejection_reason'],
        ]);

        return back()->with('success', 'Worker attendance rejected by Admin.');
    }
}
