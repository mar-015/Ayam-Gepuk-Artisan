<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('create', Schedule::class);
        
        $schedules = Schedule::with('user')
            ->orderBy('date')
            ->paginate(15);
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $this->authorize('create', Schedule::class);
        
        $users = User::where('role', '!=', 'admin')->get();
        return view('schedules.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Schedule::class);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'shift_start' => 'required|date_format:H:i',
            'shift_end' => 'required|date_format:H:i|after:shift_start',
            'shift_type' => 'required|in:morning,afternoon,night',
            'notes' => 'nullable|string|max:255',
        ]);

        $schedule = Schedule::create($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        $this->authorize('update', $schedule);
        
        $users = User::where('role', '!=', 'admin')->get();
        return view('schedules.edit', compact('schedule', 'users'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $this->authorize('update', $schedule);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'shift_start' => 'required|date_format:H:i',
            'shift_end' => 'required|date_format:H:i|after:shift_start',
            'shift_type' => 'required|in:morning,afternoon,night',
            'notes' => 'nullable|string|max:255',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $this->authorize('delete', $schedule);
        
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }

    public function mySchedule()
    {
        $this->authorize('viewMySchedule', Schedule::class);
        
        $user = Auth::user();
        $schedules = Schedule::where('user_id', $user->id)
            ->where('date', '>=', now()->subDays(7))
            ->orderBy('date')
            ->paginate(15);

        return view('schedules.my-schedule', compact('schedules'));
    }
}
