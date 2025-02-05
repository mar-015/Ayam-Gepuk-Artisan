<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Attendance Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Today's Attendance</h3>
                    @if($todayAttendance)
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-green-700">Clocked in at: {{ $todayAttendance->clock_in->format('H:i') }}</p>
                            @if($todayAttendance->clock_out)
                                <p class="text-green-700">Clocked out at: {{ $todayAttendance->clock_out->format('H:i') }}</p>
                            @else
                                <form action="{{ route('attendance.clock-out') }}" method="POST" class="mt-2">
                                    @csrf
                                    <x-primary-button>Clock Out</x-primary-button>
                                </form>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('attendance.clock-in') }}" method="POST">
                            @csrf
                            <x-primary-button>Clock In</x-primary-button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Upcoming Schedules -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Schedules</h3>
                    @if($upcomingSchedules->count() > 0)
                        <div class="space-y-4">
                            @foreach($upcomingSchedules as $schedule)
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <p class="font-medium">{{ $schedule->date->format('D, M d, Y') }}</p>
                                    <p class="text-gray-600">{{ $schedule->shift_start->format('H:i') }} - {{ $schedule->shift_end->format('H:i') }}</p>
                                    <p class="text-sm text-gray-500">{{ ucfirst($schedule->shift_type) }} Shift</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No upcoming schedules</p>
                    @endif
                </div>
            </div>

            <!-- Leave Requests -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Leave Requests</h3>
                        <a href="{{ route('leave-requests.create') }}" class="text-blue-600 hover:text-blue-800">New Request</a>
                    </div>
                    @if($pendingLeaveRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingLeaveRequests as $request)
                                <div class="border p-4 rounded-lg">
                                    <div class="flex justify-between">
                                        <div>
                                            <p class="font-medium">{{ $request->type }}</p>
                                            <p class="text-sm text-gray-600">{{ $request->start_date->format('M d') }} - {{ $request->end_date->format('M d, Y') }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($request->status === 'approved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No pending leave requests</p>
                    @endif
                </div>
            </div>

            @if(auth()->user()->isAdmin() || auth()->user()->isManager())
            <!-- Admin/Manager Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Staff Overview</h3>
                    
                    <!-- Today's Staff Attendance -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-700 mb-2">Today's Attendance</h4>
                        <div class="space-y-2">
                            @forelse($staffAttendanceToday as $attendance)
                                <div class="flex justify-between items-center border-b pb-2">
                                    <div>
                                        <p class="font-medium">{{ $attendance->user->name }}</p>
                                        <p class="text-sm text-gray-600">In: {{ $attendance->clock_in->format('H:i') }}
                                            @if($attendance->clock_out)
                                                - Out: {{ $attendance->clock_out->format('H:i') }}
                                            @endif
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-600">No attendance records for today</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pending Leave Requests -->
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Pending Leave Requests</h4>
                        <div class="space-y-4">
                            @forelse($pendingLeaveRequestsAll as $request)
                                <div class="border p-4 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium">{{ $request->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $request->type }}</p>
                                            <p class="text-sm text-gray-600">{{ $request->start_date->format('M d') }} - {{ $request->end_date->format('M d, Y') }}</p>
                                            <p class="text-sm text-gray-700 mt-1">{{ $request->reason }}</p>
                                        </div>
                                        <div class="space-x-2">
                                            <form action="{{ route('leave-requests.approve', $request) }}" method="POST" class="inline">
                                                @csrf
                                                <x-secondary-button>Approve</x-secondary-button>
                                            </form>
                                            <form action="{{ route('leave-requests.reject', $request) }}" method="POST" class="inline">
                                                @csrf
                                                <x-danger-button>Reject</x-danger-button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600">No pending leave requests</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
