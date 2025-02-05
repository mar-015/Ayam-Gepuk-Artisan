<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Today's Attendance</h3>
                        <a href="{{ route('attendance.history') }}" class="text-blue-600 hover:text-blue-800">View History</a>
                    </div>

                    <div class="space-y-6">
                        @foreach($attendances as $attendance)
                            <div class="border-l-4 {{ $attendance->clock_out ? 'border-green-500' : 'border-yellow-500' }} pl-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-600">{{ $attendance->created_at->format('M d, Y') }}</p>
                                        <p class="font-medium">Clock In: {{ $attendance->clock_in->format('H:i') }}</p>
                                        @if($attendance->clock_out)
                                            <p class="font-medium">Clock Out: {{ $attendance->clock_out->format('H:i') }}</p>
                                            <p class="text-sm text-gray-500">Duration: 
                                                {{ $attendance->clock_in->diffInHours($attendance->clock_out) }}h 
                                                {{ $attendance->clock_in->diffInMinutes($attendance->clock_out) % 60 }}m
                                            </p>
                                        @else
                                            <p class="text-yellow-600">Currently Working</p>
                                        @endif
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </div>
                                @if($attendance->notes)
                                    <p class="mt-2 text-sm text-gray-600">{{ $attendance->notes }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
