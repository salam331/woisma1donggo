<aside x-data="{
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

    <!-- Logo & Toggle -->
    <div class="flex items-center justify-between px-6 py-6 border-b dark:border-gray-700">
        <a href="{{ route('guru.dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto" x-show="open">
        </a>

        <span x-show="open" class="text-lg font-bold text-gray-700 dark:text-gray-200">
            Guru
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
    <nav x-data="{
            saveScroll() {
                localStorage.setItem('teacher-sidebar-scroll', this.$el.scrollTop);
            },
            restoreScroll() {
                const pos = localStorage.getItem('teacher-sidebar-scroll');
                if (pos !== null) this.$el.scrollTop = pos;
            }
        }"
        x-init="restoreScroll(); $el.addEventListener('scroll', () => saveScroll())"
        class="flex flex-col flex-1 py-6 space-y-2 overflow-y-auto">


        <!-- ============================= -->
        <!-- 1. DASHBOARD -->
        <!-- ============================= -->
        <a href="{{ route('guru.dashboard') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->routeIs('guru.dashboard')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->routeIs('guru.dashboard'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l9-9 9 9M4 10v10h6V14h4v6h6V10" />
            </svg>

            <span x-show="open">Dashboard</span>
        </a>


        <!-- ============================= -->
        <!-- 2. KELAS -->
        <!-- ============================= -->
        <a href="{{ route('guru.classes.index') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('guru/classes*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('guru/classes*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>

            <span x-show="open">Kelas</span>
        </a>


        <!-- ============================= -->
        <!-- 3. ABSENSI -->
        <!-- ============================= -->
        <a href="{{ route('guru.attendances.index') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('guru/attendances*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('guru/attendances*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="currentColor">
                <path d="M6 2a1 1 0 00-1 1v1H3.5A1.5 1.5 0 002 5.5v11A1.5 1.5 0 003.5 18h13a1.5 1.5 0 001.5-1.5v-11A1.5 1.5 0 0016.5 4H15V3a1 1 0 00-1-1H6zm8 4v2H6V6h8z" />
            </svg>

            <span x-show="open">Absensi</span>
        </a>


        <!-- ============================= -->
        <!-- 4. JADWAL PELAJARAN -->
        <!-- ============================= -->
        <a href="{{ route('guru.schedules.index') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('guru/schedules*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('guru/schedules*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2z" />
            </svg>

            <span x-show="open">Jadwal Pelajaran</span>
        </a>


        <!-- ============================= -->
        <!-- 5. MATERI PEMBELAJARAN -->
        <!-- ============================= -->
        <a href="{{ route('guru.materials.index') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('guru/materials*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('guru/materials*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 20l9-5V9l-9-5-9 5v6l9 5z" />
            </svg>

            <span x-show="open">Materi Pembelajaran</span>
        </a>


        <!-- ============================= -->
        <!-- 6. MATA PELAJARAN -->
        <!-- ============================= -->
        <a href="{{ route('guru.subjects.index') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('guru/subjects*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('guru/subjects*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4h16v4H4zM4 10h16v10H4z" />
            </svg>

            <span x-show="open">Mata Pelajaran</span>
        </a>


        <!-- ============================= -->
        <!-- 7. PENGUMUMAN -->
        <!-- ============================= -->
        <a href="{{ route('guru.announcements.index') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('guru/announcements*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('guru/announcements*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5l7 7-7 7" />
            </svg>

            <span x-show="open">Pengumuman</span>
        </a>


        <!-- ============================= -->
        <!-- 8. NILAI -->
        <!-- ============================= -->
        <a href="{{ route('guru.grades.index') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('guru/grades*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('guru/grades*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-6h6v6m2 4H7m10-12V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v4H5l7 7 7-7h-3z" />
            </svg>

            <span x-show="open">Nilai</span>
        </a>


        <!-- ============================= -->
        <!-- 9. UJIAN -->
        <!-- ============================= -->
        <a href="{{ route('guru.exams.index') }}"
            class="relative flex items-center space-x-3 px-3 py-2 rounded transition duration-200
            {{ request()->is('guru/exams*')
                ? 'text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">

            @if (request()->is('guru/exams*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
            </svg>

            <span x-show="open">Ujian</span>
        </a>

    </nav>
</aside>
