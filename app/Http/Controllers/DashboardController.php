<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $data = [
            'todayAttendance' => Attendance::where('user_id', $user->id)
                ->whereDate('clock_in', today())
                ->first(),
            'upcomingSchedules' => Schedule::where('user_id', $user->id)
                ->where('date', '>=', today())
                ->orderBy('date')
                ->take(5)
                ->get(),
            'pendingLeaveRequests' => LeaveRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->get(),
        ];

        if ($user->isAdmin() || $user->isManager()) {
            $data['staffAttendanceToday'] = Attendance::with('user')
                ->whereDate('clock_in', today())
                ->get();
            $data['pendingLeaveRequestsAll'] = LeaveRequest::with('user')
                ->where('status', 'pending')
                ->get();
        }

        return view('dashboard', $data);
    }
}
