<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('Profil Sekolah') }}
                    </x-nav-link>
                    <x-nav-link :href="route('gallery')" :active="request()->routeIs('gallery')">
                        {{ __('Gallery') }}
                    </x-nav-link>
                    <x-nav-link :href="route('announcements')" :active="request()->routeIs('announcements')">
                        {{ __('Announcements') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                        {{ __('Contact') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Login Link -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                    {{ __('Login') }}
                </a>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
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
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('About') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('gallery')" :active="request()->routeIs('gallery')">
                {{ __('Gallery') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('announcements')" :active="request()->routeIs('announcements')">
                {{ __('Announcements') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                {{ __('Contact') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Login Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">
                    {{ __('Login') }}
                </a>
            </div>
        </div>
    </div>
</nav>
