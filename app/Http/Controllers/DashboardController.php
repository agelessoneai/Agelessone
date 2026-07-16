<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function admin(): View
    {
        return view('admin.dashboard', [
            'usersCount' => User::count()
        ]);
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