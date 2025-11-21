<nav x-data="{ open: false, sidebarOpen: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

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

            <!-- Hamburger for Mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar Toggle for Desktop -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <button @click="sidebarOpen = ! sidebarOpen" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

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

    <!-- Sidebar for Desktop -->
    <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': ! sidebarOpen}" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out sm:block hidden">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
                <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto">
                <nav class="px-4 py-4 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-200' : '' }}">
                        Dashboard
                    </a>

                    @hasrole('admin')
                        <!-- Admin Menu -->
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Users</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Teachers</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Students</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Parents</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Classes</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Subjects</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Materials</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Schedules</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Attendances</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Invoices</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">School Profiles</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Announcements</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Galleries</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Contact Messages</a>
                    @endhasrole

                    @hasrole('guru')
                        <!-- Guru Menu -->
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Classes</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Attendances</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Schedules</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Materials</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Subjects</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Announcements</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Grades</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Exams</a>
                    @endhasrole

                    @hasrole('siswa')
                        <!-- Siswa Menu -->
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Schedules</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Attendances</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Grades</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Materials</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Announcements</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Invoices</a>
                    @endhasrole

                    @hasrole('orang_tua')
                        <!-- Orang Tua Menu -->
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Announcements</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Student Details</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Attendances</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Grades</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Invoices</a>
                    @endhasrole

                    @hasrole('publik')
                        <!-- Publik Menu -->
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">About</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Gallery</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Announcements</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">Contact</a>
                    @endhasrole
                </nav>
            </div>
        </div>
    </div>

    <!-- Overlay for Sidebar -->
    <div :class="{'opacity-50': sidebarOpen, 'opacity-0 pointer-events-none': ! sidebarOpen}" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black transition-opacity duration-300 ease-in-out sm:hidden"></div>
</nav>
