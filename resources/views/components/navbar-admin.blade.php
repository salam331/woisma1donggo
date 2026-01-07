<nav x-data="{ isOpen: false }" class="relative bg-white shadow dark:bg-gray-800 sticky top-0 z-50">
    <div class="container px-6 py-4 mx-auto">
        <div class="lg:flex lg:items-center lg:justify-between">

            <!-- Welcome & Mobile Menu Button -->
            <div class="flex items-center justify-between w-full lg:w-auto">
                <h2 class="text-2xl font-semibold mb-4 text-primary">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>

                <!-- Mobile menu button -->
                <div class="flex lg:hidden relative">
                    <button x-cloak @click="isOpen = !isOpen" type="button"
                        class="text-gray-500 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 focus:outline-none focus:text-gray-600 dark:focus:text-gray-400 p-2 rounded transition-colors"
                        aria-label="toggle menu">
                        <!-- Hamburger Icon -->
                        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                        </svg>

                        <!-- Close Icon -->
                        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Mobile Dropdown Menu -->
                    <div x-show="isOpen" @click.outside="isOpen = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 z-50">
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

                        <p class="px-4 py-2 text-gray-700 dark:text-gray-200 font-semibold border-b">
                            {{ Auth::user()->name }}
                        </p>

                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Desktop Menu & Profile Dropdown -->
            <div class="hidden lg:flex lg:items-center">
                
                <div class="flex items-center mt-4 lg:mt-0">

                    <!-- Notifications Button -->
                    <button
                        class="hidden lg:block mx-4 text-gray-600 dark:text-gray-200 hover:text-gray-700 dark:hover:text-gray-400 focus:outline-none transition-colors duration-300"
                        aria-label="show notifications">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <!-- Profile Dropdown -->
                    <div x-data="{ openProfile: false }" class="relative">
                        <button @click="openProfile = !openProfile" class="flex items-center focus:outline-none">
                            <div class="w-9 h-9 overflow-hidden border-2 border-gray-400 rounded-full">
                                @php
                                    $userPhoto = null;
                                    $userName = Auth::user()->name;
                                    
                                    // Ambil foto berdasarkan role
                                    if(Auth::user()->hasRole('siswa') && Auth::user()->student)
                                        $userPhoto = Auth::user()->student->photo;
                                    elseif(Auth::user()->hasRole('guru') && Auth::user()->teacher)
                                        $userPhoto = Auth::user()->teacher->photo;
                                    elseif(Auth::user()->hasRole('orang_tua') && Auth::user()->parent)
                                        $userPhoto = Auth::user()->parent->photo;
                                @endphp
                                
                                @if($userPhoto)
                                    <img src="{{ asset('storage/' . $userPhoto) }}" class="object-cover w-full h-full" alt="{{ $userName }}">
                                @else
                                    <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ substr($userName, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="openProfile" @click.outside="openProfile = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 z-50">
                            
                            <p class="px-4 py-2 text-gray-700 dark:text-gray-200 font-semibold border-b">
                                {{ Auth::user()->name }}
                            </p>

                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</nav>
