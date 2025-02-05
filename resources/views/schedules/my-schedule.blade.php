<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Calendar View -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Calendar View</h3>
                        <div class="grid grid-cols-7 gap-2">
                            @php
                                $startDate = now()->startOfWeek();
                                $dates = collect(range(0, 13))->map(function ($day) use ($startDate) {
                                    return $startDate->copy()->addDays($day);
                                });
                            @endphp

                            <!-- Day Headers -->
                            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                                <div class="text-center text-sm font-medium text-gray-500 py-2">
                                    {{ $dayName }}
                                </div>
                            @endforeach

                            <!-- Calendar Days -->
                            @foreach($dates as $date)
                                <div class="border rounded-lg p-2 {{ $date->isToday() ? 'bg-blue-50 border-blue-200' : '' }}">
                                    <div class="text-sm {{ $date->isToday() ? 'font-medium text-blue-600' : 'text-gray-600' }}">
                                        {{ $date->format('j') }}
                                    </div>
                                    @php
                                        $daySchedule = $schedules->first(function($schedule) use ($date) {
                                            return $schedule->date->isSameDay($date);
                                        });
                                    @endphp
                                    @if($daySchedule)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                @if($daySchedule->shift_type === 'morning') bg-yellow-100 text-yellow-800
                                                @elseif($daySchedule->shift_type === 'afternoon') bg-blue-100 text-blue-800
                                                @else bg-indigo-100 text-indigo-800 @endif">
                                                {{ ucfirst($daySchedule->shift_type) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- List View -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Shifts</h3>
                        <div class="space-y-4">
                            @forelse($schedules->where('date', '>=', now()) as $schedule)
                                <div class="border rounded-lg p-4 {{ $schedule->date->isToday() ? 'bg-blue-50 border-blue-200' : '' }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium text-gray-900">
                                                {{ $schedule->date->format('l, M j') }}
                                                @if($schedule->date->isToday())
                                                    <span class="ml-2 text-sm text-blue-600 font-medium">Today</span>
                                                @endif
                                            </p>
                                            <p class="text-gray-600">
                                                {{ \Carbon\Carbon::parse($schedule->shift_start)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($schedule->shift_end)->format('H:i') }}
                                            </p>
                                            @if($schedule->notes)
                                                <p class="mt-2 text-sm text-gray-500">{{ $schedule->notes }}</p>
                                            @endif
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($schedule->shift_type === 'morning') bg-yellow-100 text-yellow-800
                                            @elseif($schedule->shift_type === 'afternoon') bg-blue-100 text-blue-800
                                            @else bg-indigo-100 text-indigo-800 @endif">
                                            {{ ucfirst($schedule->shift_type) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No upcoming shifts scheduled.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-6">
                        {{ $schedules->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
