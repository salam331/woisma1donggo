<aside
    x-data="{
        open: window.innerWidth >= 768,
        init() {
            window.addEventListener('resize', () => {
                this.open = window.innerWidth >= 768;
            });
        },
        toggle() { this.open = !this.open }
    }"
    :class="open ? 'w-64' : 'w-16'"
    class="flex flex-col h-screen bg-white dark:bg-gray-900 border-r dark:border-gray-700 transition-all duration-300 sticky top-0">

    <!-- LOGO & TOGGLE -->
    <div class="flex items-center justify-between px-6 py-6 border-b dark:border-gray-700">
        <a href="{{ route('siswa.dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto" x-show="open">
        </a>

        <span x-show="open" class="text-lg font-bold text-gray-700 dark:text-gray-200">
            Student
        </span>

        <button @click="toggle()" class="text-gray-700 dark:text-gray-200 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-8" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- MENU -->
    <nav
        x-data="{
            saveScroll() {
                localStorage.setItem('student-sidebar-scroll', this.$el.scrollTop);
            },
            restoreScroll() {
                const pos = localStorage.getItem('student-sidebar-scroll');
                if (pos !== null) this.$el.scrollTop = pos;
            }
        }"
        x-init="restoreScroll(); $el.addEventListener('scroll', () => saveScroll())"
        class="flex flex-col flex-1 py-6 space-y-2 overflow-y-auto">

        {{-- ============================= --}}
        {{-- 1. DASHBOARD --}}
        {{-- ============================= --}}
        <a href="{{ route('siswa.dashboard') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('siswa/dashboard*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('siswa/dashboard*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l9-9 9 9M4 10v10h6V14h4v6h6V10" />
            </svg>

            <span x-show="open">Dashboard</span>
        </a>

        {{-- ============================= --}}
        {{-- 2. JADWAL PELAJARAN --}}
        {{-- ============================= --}}
        <a href="{{ url('/siswa/schedules') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('siswa/schedules*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('siswa/schedules*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2z" />
            </svg>

            <span x-show="open">Jadwal Pelajaran</span>
        </a>

        {{-- ============================= --}}
        {{-- 3. RIWAYAT ABSENSI --}}
        {{-- ============================= --}}
        <a href="{{ url('/siswa/attendances') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('siswa/attendances*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('siswa/attendances*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="currentColor">
                <path
                    d="M6 2a1 1 0 00-1 1v1H3.5A1.5 1.5 0 002 5.5v11A1.5 1.5 0 003.5 18h13a1.5 1.5 0 001.5-1.5v-11A1.5 1.5 0 0016.5 4H15V3a1 1 0 00-1-1H6zm8 4v2H6V6h8z" />
            </svg>

            <span x-show="open">Riwayat Absensi</span>
        </a>

        {{-- ============================= --}}
        {{-- 4. NILAI --}}
        {{-- ============================= --}}

        <a href="{{ route('siswa.grades.subjects') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('siswa/grades*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('siswa/grades*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-6h6v6m2 4H7m10-12V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v4H5l7 7 7-7h-3z" />
            </svg>

            <span x-show="open">Nilai</span>
        </a>

        {{-- ============================= --}}
        {{-- 5. MATERI PEMBELAJARAN --}}
        {{-- ============================= --}}
        <a href="{{ url('/siswa/materials') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('siswa/materials*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('siswa/materials*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 20l9-5V9l-9-5-9 5v6l9 5z" />
            </svg>

            <span x-show="open">Materi Pembelajaran</span>
        </a>

        {{-- ============================= --}}
        {{-- 6. PENGUMUMAN --}}
        {{-- ============================= --}}
        <a href="{{ url('/siswa/announcements') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('siswa/announcements*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('siswa/announcements*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5l7 7-7 7" />
            </svg>

            <span x-show="open">Pengumuman</span>
        </a>

        {{-- ============================= --}}
        {{-- 7. TAGIHAN --}}
        {{-- ============================= --}}
        <a href="{{ url('/siswa/bills') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('siswa/bills*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('siswa/bills*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10v2m0 8v2" />
            </svg>

            <span x-show="open">Tagihan</span>
        </a>

    </nav>
</aside>
