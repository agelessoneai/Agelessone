<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function punchIn(Request $request)
    {
        Attendance::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'date' => today()->toDateString(),
            ],
            [
                'punch_in' => now(),
                'status' => 'present',
                'location' => $request->location,
            ]
        );

        return back()->with('success', 'Punch In recorded successfully.');
    }

    public function punchOut(Request $request)
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', today()->toDateString())
            ->firstOrFail();

        $attendance->punch_out = now();
        $attendance->punch_out_location = $request->location;

        if ($attendance->punch_in) {
            $attendance->total_minutes = Carbon::parse($attendance->punch_in)
                ->diffInMinutes(now());
        }

        $attendance->save();

        return back()->with('success', 'Punch Out recorded successfully.');
    }

    public function adminIndex()
    {
        $attendances = Attendance::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.attendance', compact('attendances'));
    }
}