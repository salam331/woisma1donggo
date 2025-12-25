<aside x-data="{
        open: window.innerWidth >= 768,
        init() {
            window.addEventListener('resize', () => {
                this.open = window.innerWidth >= 768;
            });
        },
        toggle() { this.open = !this.open }
    }" :class="open ? 'w-64' : 'w-16'"
    class="flex flex-col h-screen bg-white dark:bg-gray-900 border-r dark:border-gray-700 transition-all duration-300 sticky top-0">


    <!-- LOGO & TOGGLE -->
    <div class="flex items-center justify-between px-6 py-6 border-b dark:border-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.png') }}" alt="+" class="h-8 w-auto" x-show="open">
        </a>
        <span x-show="open"
            class="text-lg font-bold text-gray-700 dark:text-gray-200 transition-opacity duration-300">Admin</span>
        <!-- Toggle Button -->
        {{-- <button @click="open = !open" class="text-gray-700 dark:text-gray-200 focus:outline-none"> --}}
            <button @click="toggle()" class="text-gray-700 dark:text-gray-200 focus:outline-none">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
    </div>

    {{-- <nav class="flex flex-col flex-1 py-6 space-y-2"> --}}
        <nav x-data="{
        saveScroll() {
            localStorage.setItem('sidebar-scroll', this.$el.scrollTop);
        },
        restoreScroll() {
            const pos = localStorage.getItem('sidebar-scroll');
            if (pos !== null) {
                this.$el.scrollTop = pos;
            }
        }
    }" x-init="restoreScroll(); $el.addEventListener('scroll', () => saveScroll())"
            class="flex flex-col flex-1 py-6 space-y-2 overflow-y-auto">

            {{-- menandai menu yang sedang aktif --}}

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->routeIs('admin.dashboard')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->routeIs('admin.dashboard'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l9-9 9 9M4 10v10h6V14h4v6h6V10" />
                </svg>

                <span x-show="open">Dashboard</span>
            </a>


            <!-- Users -->
            <a href="{{ route('admin.users.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/users*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/users*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2M9 10a4 4 0 110-8 4 4 0 010 8z" />
                </svg>

                <span x-show="open" class="transition-opacity duration-300">Users</span>
            </a>


            <!-- Teachers -->
            <a href="{{ route('admin.teachers.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/teachers*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/teachers*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M12 14l9-5-9-5-9 5 9 5zm0 0v7" />
                </svg>

                <span x-show="open" class="transition-opacity duration-300">Daftar Guru</span>
            </a>


            <!-- Students -->
            <a href="{{ route('admin.students.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/students*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/students*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M12 14c4.418 0 8 1.79 8 4v2H4v-2c0-2.21 3.582-4 8-4zM12 12a4 4 0 100-8 4 4 0 000 8z" />
                </svg>

                <span x-show="open" class="transition-opacity duration-300">Daftar Siswa</span>
            </a>


            <!-- Parents -->
            <a href="{{ route('admin.parents.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/parents*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/parents*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20v-2a4 4 0 00-3-3.87M7 20v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z" />
                </svg>

                <span x-show="open" class="transition-opacity duration-300">Daftar Ortu</span>
            </a>


            <!-- Classes -->
            <a href="{{ route('admin.classes.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/classes*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/classes*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10" />
                </svg>

                <span x-show="open">Daftar Kelas</span>
            </a>


            <!-- Subjects -->
            <a href="{{ route('admin.subjects.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/subjects*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/subjects*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M12 20l9-4-9-4-9 4 9 4zm0-12l9-4-9-4-9 4 9 4z" />
                </svg>

                <span x-show="open">Daftar Mapel</span>
            </a>


            <!-- Materials -->
            <a href="{{ route('admin.materials.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/materials*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/materials*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" stroke="currentColor" fill="none">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-6a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>

                <span x-show="open">Daftar Materi</span>
            </a>


            {{-- Exam --}}
            <a href="{{ route('admin.exams.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/exams*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/exams*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>

                <span x-show="open">Daftar Ujian</span>
            </a>


            <!-- Schedules -->
            <a href="{{ route('admin.schedules.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/schedules*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/schedules*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7H3v10a2 2 0 002 2z" />
                </svg>

                <span x-show="open">Daftar Jadwal</span>
            </a>


            {{-- Grades --}}
            <a href="{{ route('admin.grades.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/grades*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/grades*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M9 19V6l12-3v13M9 19c-4.639 0-8.4-1.12-8.4-2.5S4.361 14 9 14s8.4 1.12 8.4 2.5V6M9 19c0 1.38 3.761 2.5 8.4 2.5s8.4-1.12 8.4-2.5" />
                </svg>

                <span x-show="open">Daftar Nilai</span>
            </a>


            <!-- Attendances -->
            <a href="{{ route('admin.attendances.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/attendances*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/attendances*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-3-3v6m9-9H3v12h18V6z" />
                </svg>

                <span x-show="open">Daftar Absensi</span>
            </a>

            <!-- Invoices -->
            <a href="{{ route('admin.invoices.index') }}" class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
        {{ request()->is('admin/invoices*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                @if (request()->is('admin/invoices*'))
                    <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                @endif

                <svg class="w-6 h-6" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M9 14h6m-6 4h6M7 3h10a2 2 0 012 2v14l-5-3-5 3V5a2 2 0 012-2z" />
                </svg>

                <span x-show="open">Daftar Tagihan</span>
            </a>


            <!-- Public Dashboard Dropdown -->
            <div x-data="{ openDropdown: {{ request()->is('dashboard') || request()->is('admin/announcements*') || request()->is('admin/contact-messages*') || request()->is('admin/galleries*') || request()->is('admin/school-profiles*') || request()->is('admin/informasi-akademik*') ? 'true' : 'false' }} }"
                class="relative text-gray-700 dark:text-gray-300">

                <!-- Determine active group -->
                @php
                    $publicActive = request()->is('dashboard') ||
                        request()->is('admin/announcements*') ||
                        request()->is('admin/contact-messages*') ||
                        request()->is('admin/galleries*') ||
                        request()->is('admin/school-profiles*') ||
                        request()->is('admin/informasi-akademik*');
                @endphp

                <!-- Trigger -->
                <button @click="openDropdown = !openDropdown" class="relative w-full flex items-center justify-between px-3 py-2 rounded transition duration-200
            {{ $publicActive
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">

                    @if ($publicActive)
                        <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                    @endif

                    <div class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l9-9 9 9M4 10v10h6V14h4v6h6V10" />
                        </svg>

                        <span x-show="open" class="transition-opacity duration-300">Halaman Publik</span>
                    </div>

                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': openDropdown}"
                        class="w-5 h-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Items -->
                <div x-show="openDropdown" x-collapse class="ml-10 mt-2 space-y-1">

                    {{-- Dashboard Publik --}}
                    <a href="{{ route('dashboard') }}" class="relative block px-3 py-2 rounded transition duration-200
                {{ request()->is('dashboard')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        @if (request()->is('dashboard'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                        @endif
                        Dashboard Publik
                    </a>

                    {{-- Announcements --}}
                    <a href="{{ route('admin.announcements.index') }}" class="relative block px-3 py-2 rounded transition duration-200
                {{ request()->is('admin/announcements*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        @if (request()->is('admin/announcements*'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                        @endif
                        Announcements
                    </a>

                    {{-- Contact Messages --}}
                    <a href="{{ route('admin.contact-messages.index') }}" class="relative block px-3 py-2 rounded transition duration-200
                {{ request()->is('admin/contact-messages*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        @if (request()->is('admin/contact-messages*'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                        @endif
                        Contact Messages
                    </a>

                    {{-- Galleries --}}
                    <a href="{{ route('admin.galleries.index') }}" class="relative block px-3 py-2 rounded transition duration-200
                {{ request()->is('admin/galleries*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        @if (request()->is('admin/galleries*'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                        @endif
                        Galleries
                    </a>

                    {{-- School Profiles --}}
                    <a href="{{ route('admin.school-profiles.index') }}" class="relative block px-3 py-2 rounded transition duration-200
                {{ request()->is('admin/school-profiles*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        @if (request()->is('admin/school-profiles*'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                        @endif
                        School Profiles
                    </a>

                    {{-- Informasi Akademik --}}
                    <a href="{{ url('/admin/informasi-akademik') }}" class="relative block px-3 py-2 rounded transition duration-200
                {{ request()->is('admin/informasi-akademik*')
    ? 'text-blue-600 dark:text-blue-400 font-semibold'
    : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        @if (request()->is('admin/informasi-akademik*'))
                            <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 dark:bg-blue-400 rounded"></span>
                        @endif
                        Informasi Akademik
                    </a>

                </div>
            </div>



        </nav>

        <!-- USER PROFILE -->
        {{-- <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center space-x-3">
            <img class="w-8 h-8 rounded-full object-cover"
                src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=facearea&facepad=4&w=880&h=880&q=100" />
            <div x-show="open" class="flex flex-col transition-opacity duration-300">
                <span class="text-gray-800 dark:text-gray-200 text-sm font-medium">Admin</span>
                <span class="text-gray-500 dark:text-gray-400 text-xs">Settings</span>
            </div>
        </div> --}}
</aside>