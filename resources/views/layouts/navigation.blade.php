<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('form') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link> --}}
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('form')" :active="request()->routeIs('form')">
                        {{ __('Form') }}
                    </x-nav-link>
                </div>
                <div class="relative hidden space-x-8 sm:-my-px sm:ms-10 sm:flex group">
                    <!-- Parent Report Link -->
                    <x-nav-link class="flex items-center">
                        {{ __('Report') }}
                        <!-- Dropdown Icon -->
                        <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </x-nav-link>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute left-0 mt-2 hidden w-48 bg-white border border-gray-200 rounded-md shadow-lg group-hover:block">
                        <x-dropdown-link :href="route('check_in_out_report')">
                            {{ __('Check in/out Report') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('room_list_report')">
                            {{ __('Room List Report') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('check_in_report')">
                            {{ __('Check In Report') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('driver_report')">
                            {{ __('Driver Report') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('pax_report')">
                            {{ __('Pax Report') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('daily_guest_sum_report')">
                            {{ __('Daily Guest Sum Report') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('name_list_report')">
                            {{ __('Name List Report') }}
                        </x-dropdown-link>
                            {{-- Additional Dropdown Items (Uncomment if needed) --}}
                        {{-- <a href="{{ route('form.sub2') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Sub Form 2') }}
                        </a>
                        <a href="{{ route('form.sub3') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Sub Form 3') }}
                        </a> --}}
                    </div>
                </div>
                       
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            @if(Auth::check())
                                <div>{{ Auth::user()->name }}</div>
                            @else
                                <script>window.location.href = "{{ route('login') }}";</script>
                            @endif

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link> --}}

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
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
        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div> --}}
        <div class="flex items-center space-x-8">
            <!-- Form Link -->
            <x-nav-link :href="route('form')" :active="request()->routeIs('form')">
                {{ __('Form') }}
            </x-nav-link>
        
            <!-- Dropdown Menu (Report) -->
            <div x-data="{ open: false }" class="relative">
                <!-- Parent Report Link -->
                <x-nav-link @click="open = !open" @keydown.escape.window="open = false" class="flex items-center cursor-pointer">
                    {{ __('Report') }}
                    <!-- Dropdown Icon -->
                    <svg class="w-4 h-4 ms-2 transform transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </x-nav-link>
        
                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg">
                    <x-dropdown-link :href="route('check_in_out_report')">
                        {{ __('Check in/out Report') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('room_list_report')">
                        {{ __('Room List Report') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('check_in_report')">
                        {{ __('Check In Report') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('driver_report')">
                        {{ __('Driver Report') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('pax_report')">
                        {{ __('Pax Report') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('daily_guest_sum_report')">
                        {{ __('Daily Guest Sum Report') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('snorkelling_report')">
                        {{ __('Snorkelling Report') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('name_list_report')">
                        {{ __('Name List Report') }}
                    </x-dropdown-link>
                </div>
            </div>
        </div>
                
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                @if(Auth::check())
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            @else
                <script>window.location.href = "{{ route('login') }}";</script>
            @endif
            </div>

            <div class="mt-3 space-y-1">
                {{-- <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link> --}}

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
