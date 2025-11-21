<x-publik-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Publik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-4">Selamat Datang di Sistem Administrasi SMAN 1 Donggo</h1>
                    <p class="text-lg mb-6">Platform modern untuk manajemen sekolah yang efisien dan mudah digunakan.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-blue-800 mb-2">Tentang Kami</h3>
                            <p class="text-blue-600">Pelajari lebih lanjut tentang sekolah kami.</p>
                            <a href="{{ route('about') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lihat Detail</a>
                        </div>

                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-green-800 mb-2">Galeri</h3>
                            <p class="text-green-600">Lihat koleksi foto dan kegiatan sekolah.</p>
                            <a href="{{ route('gallery') }}" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Lihat Galeri</a>
                        </div>

                        <div class="bg-yellow-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-yellow-800 mb-2">Pengumuman</h3>
                            <p class="text-yellow-600">Informasi terbaru dari sekolah.</p>
                            <a href="{{ route('announcements') }}" class="mt-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Lihat Pengumuman</a>
                        </div>

                        <div class="bg-purple-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold text-purple-800 mb-2">Kontak</h3>
                            <p class="text-purple-600">Hubungi kami untuk informasi lebih lanjut.</p>
                            <a href="{{ route('contact') }}" class="mt-4 inline-block bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-publik-layout>
