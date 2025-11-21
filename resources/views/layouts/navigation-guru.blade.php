<div x-data="{ sidebarOpen: false }">
    <nav class="bg-white shadow md:ml-64">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Hamburger Mobile -->
                    <div class="flex items-center sm:hidden">
                        <button
                            @click="sidebarOpen = !sidebarOpen"
                            class="p-2 rounded-md text-gray-600 hover:bg-gray-200 transition">
                            <template x-if="!sidebarOpen">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </template>

                            <template x-if="sidebarOpen">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </template>
                        </button>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="flex items-center">
                    <x-dropdown align="right" width="auto">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </nav>

    <!-- Desktop Sidebar -->
    <div class="bg-gray-800 text-white w-64 min-h-screen fixed top-0 left-0 z-10 hidden md:block">
        <div class="p-4">
            {{-- tambahkan logo di atas h2 dan posisinya di tengah--}}
            <div class="flex justify-center mb-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMAN 1 Donggo" class="block h-12 w-auto">
            </div>
            <h2 class="text-xl font-bold mb-7 text-center">Guru Panel</h2>
            <ul class="space-y-2">
                {{-- <li><a href="{{ route('guru.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.dashboard') ? 'bg-gray-700' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('guru.classes.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.classes.*') ? 'bg-gray-700' : '' }}">Classes</a></li>
                <li><a href="{{ route('guru.students.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.students.*') ? 'bg-gray-700' : '' }}">Students</a></li>
                <li><a href="{{ route('guru.materials.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.materials.*') ? 'bg-gray-700' : '' }}">Materials</a></li>
                <li><a href="{{ route('guru.schedules.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.schedules.*') ? 'bg-gray-700' : '' }}">Schedules</a></li>
                <li><a href="{{ route('guru.attendances.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.attendances.*') && !request()->routeIs('guru.attendances.summary') ? 'bg-gray-700' : '' }}">Attendances</a></li>
                <li><a href="{{ route('guru.announcements.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.announcements.*') ? 'bg-gray-700' : '' }}">Announcements</a></li>
                <li><a href="{{ route('guru.galleries.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.galleries.*') ? 'bg-gray-700' : '' }}">Galleries</a></li> --}}
            </ul>
        </div>
    </div>

    <!-- MOBILE Sidebar + Overlay -->
    <div class="md:hidden" x-cloak>
    <!-- Overlay -->
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-transparent bg-opacity-50 z-20 transition-opacity"
        x-transition.opacity
    ></div>

    <!-- Sidebar -->
    <div
        x-show="sidebarOpen"
        class="fixed top-0 left-0 z-30 w-64 min-h-screen bg-gray-800 text-white transform transition-all duration-300"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
    >
        <div class="p-4">
            {{-- <h2 class="text-xl font-bold mb-4">guru Panel</h2> --}}
            <div class="flex justify-center mb-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMAN 1 Donggo" class="block h-12 w-auto">
            </div>
            <h2 class="text-xl font-bold mb-7 text-center">Guru Panel</h2>
            <ul class="space-y-2">
                {{-- <li><a href="{{ route('guru.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.dashboard') ? 'bg-gray-700' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('guru.classes.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.classes.*') ? 'bg-gray-700' : '' }}">Classes</a></li>
                <li><a href="{{ route('guru.students.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.students.*') ? 'bg-gray-700' : '' }}">Students</a></li>
                <li><a href="{{ route('guru.materials.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.materials.*') ? 'bg-gray-700' : '' }}">Materials</a></li>
                <li><a href="{{ route('guru.schedules.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.schedules.*') ? 'bg-gray-700' : '' }}">Schedules</a></li>
                <li><a href="{{ route('guru.attendances.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.attendances.*') && !request()->routeIs('guru.attendances.summary') ? 'bg-gray-700' : '' }}">Attendances</a></li>
                <li><a href="{{ route('guru.announcements.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.announcements.*') ? 'bg-gray-700' : '' }}">Announcements</a></li>
                <li><a href="{{ route('guru.galleries.index') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('guru.galleries.*') ? 'bg-gray-700' : '' }}">Galleries</a></li> --}}
            </ul>
        </div>
    </div>
</div>
