<aside x-data="{ open: true }" :class="open ? 'w-64' : 'w-16'"
    class="flex flex-col h-screen bg-white dark:bg-gray-900 border-r dark:border-gray-700 transition-all duration-300">

    <!-- LOGO & TOGGLE -->
    <div class="flex items-center justify-between px-6 py-6 border-b dark:border-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.png') }}" alt="+" class="h-8 w-auto" x-show="open">
        </a>
        <span x-show="open"
                class="text-lg font-bold text-gray-700 dark:text-gray-200 transition-opacity duration-300">Admin</span>
        <!-- Toggle Button -->
        <button @click="open = !open" class="text-gray-700 dark:text-gray-200 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-8" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- NAVIGATION -->
    <nav class="flex flex-col flex-1 py-6 space-y-2">

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l9-9 9 9M4 10v10h6V14h4v6h6V10"/>
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Dashboard</span>
        </a>

        <!-- Users -->
        <a href="{{ url('/admin/users') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2M9 10a4 4 0 110-8 4 4 0 010 8z" />
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Users</span>
        </a>

        <!-- Teachers -->
        <a href="{{ url('/admin/teachers') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M12 14l9-5-9-5-9 5 9 5zm0 0v7" />
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Daftar Guru</span>
        </a>

        <!-- Students -->
        <a href="{{ url('/admin/students') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M12 14c4.418 0 8 1.79 8 4v2H4v-2c0-2.21 3.582-4 8-4zM12 12a4 4 0 100-8 4 4 0 000 8z" />
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Daftar Siswa</span>
        </a>

        <!-- Parents -->
        <a href="{{ url('/admin/parents') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M17 20v-2a4 4 0 00-3-3.87M7 20v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z" />
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Daftar Ortu</span>
        </a>

        <!-- Classes -->
        <a href="{{ url('/admin/classes') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10" />
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Daftar Kelas</span>
        </a>

        <!-- Subjects -->
        <a href="{{ url('/admin/subjects') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M12 20l9-4-9-4-9 4 9 4zm0-12l9-4-9-4-9 4 9 4z" />
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Daftar Mapel</span>
        </a>

        <!-- Materials -->
        <a href="{{ url('/admin/materials') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-6a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Daftar Materi</span>
        </a>

        <!-- Schedules -->
        <a href="{{ url('/admin/schedules') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7H3v10a2 2 0 002 2z" />
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Daftar Jadwal</span>
        </a>

        <!-- Attendances -->
        <a href="{{ url('/admin/attendances') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-3-3v6m9-9H3v12h18V6z" />
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Daftar Absensi</span>
        </a>

        <!-- Invoices -->
        <a href="{{ url('/admin/invoices') }}" class="flex items-center space-x-3 px-3 py-2 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-100 
              dark:hover:bg-gray-800 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M9 14h6m-6 4h6M7 3h10a2 2 0 012 2v14l-5-3-5 3V5a2 2 0 012-2z" />
            </svg>
            <span x-show="open" class="transition-opacity duration-300">Daftar Tagihan</span>
        </a>

    </nav>

    <!-- USER PROFILE -->
    <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center space-x-3">
        <img class="w-8 h-8 rounded-full object-cover"
            src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=facearea&facepad=4&w=880&h=880&q=100" />
        <div x-show="open" class="flex flex-col transition-opacity duration-300">
            <span class="text-gray-800 dark:text-gray-200 text-sm font-medium">Admin</span>
            <span class="text-gray-500 dark:text-gray-400 text-xs">Settings</span>
        </div>
    </div>
</aside>