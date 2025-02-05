<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('schedules.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Staff Selection -->
                        <div>
                            <x-input-label for="user_id" :value="__('Staff Member')" />
                            <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Staff Member</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        </div>

                        <!-- Date -->
                        <div>
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date')" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Shift Type -->
                        <div>
                            <x-input-label for="shift_type" :value="__('Shift Type')" />
                            <select id="shift_type" name="shift_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="morning" {{ old('shift_type') == 'morning' ? 'selected' : '' }}>Morning</option>
                                <option value="afternoon" {{ old('shift_type') == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                                <option value="night" {{ old('shift_type') == 'night' ? 'selected' : '' }}>Night</option>
                            </select>
                            <x-input-error :messages="$errors->get('shift_type')" class="mt-2" />
                        </div>

                        <!-- Shift Start -->
                        <div>
                            <x-input-label for="shift_start" :value="__('Shift Start Time')" />
                            <x-text-input id="shift_start" name="shift_start" type="time" class="mt-1 block w-full" :value="old('shift_start')" required />
                            <x-input-error :messages="$errors->get('shift_start')" class="mt-2" />
                        </div>

                        <!-- Shift End -->
                        <div>
                            <x-input-label for="shift_end" :value="__('Shift End Time')" />
                            <x-text-input id="shift_end" name="shift_end" type="time" class="mt-1 block w-full" :value="old('shift_end')" required />
                            <x-input-error :messages="$errors->get('shift_end')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div>
                            <x-input-label for="notes" :value="__('Notes')" />
                            <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('schedules.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>{{ __('Create Schedule') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
