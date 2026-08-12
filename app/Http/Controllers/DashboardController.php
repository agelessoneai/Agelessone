<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use App\Models\AdminNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function admin(): View
    {
        return view('admin.dashboard', [
            'usersCount' => User::count(),
            'adminNotifications' => AdminNotification::with(['user', 'attendance'])->latest()->limit(10)->get(),
            'unreadAdminNotifications' => AdminNotification::whereNull('read_at')->count(),
        ]);
    }

    public function markNotificationRead(AdminNotification $notification): RedirectResponse
    {
        $notification->update(['read_at' => now()]);
        return back()->with('success', 'Notification marked as read.');
    }

    public function users(): View
    {
        return view('admin.users', [
            'users' => User::latest()->paginate(10)
        ]);
    }

    public function user(): View
    {
        $user = auth()->user();
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', today())
            ->first();

        $todayMinutes = 0;
        if ($attendance) {
            if ($attendance->punch_out) {
                $todayMinutes = $attendance->total_minutes ?? 0;
            } elseif ($attendance->punch_in) {
                $todayMinutes = max(0, (int) now()->diffInMinutes($attendance->punch_in));
            }
        }

        $monthMinutes = Attendance::where('user_id', $user->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total_minutes');

        $weekMinutes = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total_minutes');

        if ($attendance && !$attendance->punch_out && $attendance->punch_in) {
            $ongoing = max(0, (int) now()->diffInMinutes($attendance->punch_in));
            $monthMinutes += $ongoing;
            $weekMinutes += $ongoing;
        }

        return view('user.dashboard', compact('attendance', 'todayMinutes', 'monthMinutes', 'weekMinutes'));
    }
}