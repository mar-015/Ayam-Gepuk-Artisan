<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('attendance.index', compact('attendances'));
    }

    /**
     * Clock in the user.
     */
    public function clockIn()
    {
        $user = Auth::user();
        
        // Check if already clocked in today
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('clock_in', today())
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'You have already clocked in today.');
        }

        Attendance::create([
            'user_id' => $user->id,
            'clock_in' => now(),
            'status' => 'present'
        ]);

        return redirect()->back()->with('success', 'Clocked in successfully.');
    }

    /**
     * Clock out the user.
     */
    public function clockOut()
    {
        $user = Auth::user();
        
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('clock_in', today())
            ->whereNull('clock_out')
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'No active clock-in found.');
        }

        $attendance->update([
            'clock_out' => now()
        ]);

        return redirect()->back()->with('success', 'Clocked out successfully.');
    }

    /**
     * Display the attendance history.
     */
    public function history()
    {
        $user = Auth::user();
        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('attendance.history', compact('attendances'));
    }
}
