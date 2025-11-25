<header x-data="{ isOpen: false }" class="relative bg-white dark:bg-gray-800 shadow-md">
    <div class="container px-6 py-8 mx-auto flex items-center justify-between">

        <!-- Logo / Title -->
        <div class="flex items-center">
            {{-- logo --}}
            <img src="{{ asset('images/logo.png') }}" alt="Logo SMAN 1 Donggo" class="w-10 h-10 mr-2">
            <div class="text-xl font-bold text-primary dark:text-primary">SMAN 1 Donggo</div>
        </div>
       

        <!-- Desktop Menu -->
        <nav class="hidden md:flex space-x-6">
            <a href="{{ route('dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary">Beranda</a>
            <a href="{{ route('about') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary">Profil Sekolah</a>
            <a href="{{ route('informasi-akademik') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary">Informasi Akademik</a>
            <a href="{{ route('announcements') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary">Berita & Pengumuman</a>
            <a href="{{ route('gallery') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary">Galeri</a>
            <a href="{{ route('contact') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary">Kontak</a>
        </nav>

        <!-- Mobile Menu Button -->
        <button @click="isOpen = !isOpen" 
                class="md:hidden text-gray-700 dark:text-gray-300 focus:outline-none" 
                aria-label="toggle mobile menu">
            <!-- Hamburger -->
            <svg x-show="!isOpen" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>

            <!-- Close -->
            <svg x-show="isOpen" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div 
        x-show="isOpen"
        x-cloak
        x-transition:enter="transition-all duration-300 ease-out"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition-all duration-300 ease-in"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden mt-2 space-y-2 bg-white dark:bg-gray-800 py-3 rounded-lg shadow-lg px-4"
    >
        <a href="/" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Beranda</a>
        <a href="profil" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Profil Sekolah</a>
        <a href="informasi-akademik" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Informasi Akademik</a>
        <a href="berita" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Berita & Pengumuman</a>
        <a href="galeri" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Galeri</a>
        <a href="kontak" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">Kontak</a>
    </div>
</header>
