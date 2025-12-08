@extends('layouts.guest')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
    {{ __('Galeri') }}
</h2>
@endsection

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20 px-6 shadow-lg">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow">
            Galeri SMAN 1 Donggo
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-3xl mx-auto">
            Dokumentasi kegiatan, acara, dan fasilitas sekolah yang menggambarkan aktivitas belajar dan kreativitas siswa.
        </p>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-16 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Section Title -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Koleksi Foto</h2>
            <p class="text-gray-600 dark:text-gray-400">Temukan momen terbaik dari berbagai kegiatan sekolah.</p>
        </div>

        @if($galleries->count() > 0)

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($galleries as $gallery)
            <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transform hover:-translate-y-1 hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 cursor-pointer"
                onclick="window.location.href='{{ route('gallery.show', $gallery->id) }}'">

                <!-- Image -->
                <div class="relative overflow-hidden">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}"
                        alt="{{ $gallery->title }}"
                        class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>

                <!-- Content -->
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                        {{ $gallery->title }}
                    </h3>

                    @if($gallery->description)
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2">
                        {{ $gallery->description }}
                    </p>
                    @endif

                    <div class="flex justify-between items-center mt-4">

                        @if($gallery->category)
                        <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                            {{ $gallery->category }}
                        </span>
                        @endif

                        @if($gallery->event_date)
                        <span class="text-gray-500 dark:text-gray-400 text-xs">
                            {{ $gallery->event_date->format('d M Y') }}
                        </span>
                        @endif
                    </div>
                </div>

            </div>
            @endforeach

        </div>

        <!-- Pagination -->
        {{-- <div class="mt-12">
            {{ $galleries->links('pagination::tailwind') }}
        </div> --}}

        @else
        <p class="text-center text-gray-500 dark:text-gray-400 text-lg">
            Belum ada galeri yang tersedia.
        </p>
        @endif

    </div>
</section>

@endsection
