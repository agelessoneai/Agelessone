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
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', today())
            ->first();

        return view('user.dashboard', compact('attendance'));
    }
}