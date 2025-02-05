<nav x-data="{ open: false }" class="bg-yellow-500">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                <img src="{{ asset('images/ayam-gepuk-artisan.png') }}" alt="Ayam Gepuk Artisan Logo" class="h-12 w-auto bg-white p-1 rounded">
                </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-yellow-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                        <x-nav-link :href="route('schedules.index')" :active="request()->routeIs('schedules.*')" class="text-white hover:text-yellow-200">
                            {{ __('Schedules') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('schedules.my-schedule')" :active="request()->routeIs('schedules.my-schedule')" class="text-white hover:text-yellow-200">
                            {{ __('My Schedule') }}
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('attendance.index')" :active="request()->routeIs('attendance.*')" class="text-white hover:text-yellow-200">
                        {{ __('Attendance') }}
                    </x-nav-link>

                    <x-nav-link :href="route('leave-requests.index')" :active="request()->routeIs('leave-requests.*')" class="text-white hover:text-yellow-200">
                        {{ __('Leave Requests') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Notification Icon -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <a href="{{ route('notifications.index') }}" class="relative p-2 text-white hover:text-yellow-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span id="notification-count" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">0</span>
                </a>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-yellow-200 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-yellow-50">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="hover:bg-yellow-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-yellow-200 hover:bg-yellow-600 focus:outline-none focus:bg-yellow-600 focus:text-yellow-200 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-yellow-200">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                <x-responsive-nav-link :href="route('schedules.index')" :active="request()->routeIs('schedules.*')" class="text-white hover:text-yellow-200">
                    {{ __('Schedules') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('schedules.my-schedule')" :active="request()->routeIs('schedules.my-schedule')" class="text-white hover:text-yellow-200">
                    {{ __('My Schedule') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('attendance.index')" :active="request()->routeIs('attendance.*')" class="text-white hover:text-yellow-200">
                {{ __('Attendance') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('leave-requests.index')" :active="request()->routeIs('leave-requests.*')" class="text-white hover:text-yellow-200">
                {{ __('Leave Requests') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')" class="text-white hover:text-yellow-200">
                {{ __('Notifications') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-yellow-400">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-yellow-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:text-yellow-200">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-white hover:text-yellow-200">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
