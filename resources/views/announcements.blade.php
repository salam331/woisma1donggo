@extends('layouts.guest')

@section('header')
<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
    Pengumuman
</h2>
@endsection

@section('content')

<section class="mt-24">

    <!-- HERO SECTION -->
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16 shadow-lg">
        <div class="container px-6 mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">
                Pengumuman Terbaru
            </h1>
            <p class="mt-4 text-lg md:text-xl text-blue-100 dark:text-gray-300">
                Informasi resmi terbaru dari SMAN 1 Donggo
            </p>
        </div>
    </div>

    <!-- CONTENT SECTION -->
    <div class="bg-gray-50 dark:bg-gray-900 py-14">
        <div class="container px-6 mx-auto">

            <!-- Grid pengumuman -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">

                @forelse($announcements as $announcement)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 cursor-pointer group"
                    onclick="openModal('modal-{{ $announcement->id }}')">

                    <!-- Gambar -->
                    @if($announcement->image)
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . $announcement->image) }}"
                             alt="{{ $announcement->title }}"
                             class="object-cover w-full h-48 lg:h-56 group-hover:scale-105 transition duration-500">

                        <span class="absolute bottom-2 right-2 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded">
                            {{ $announcement->publish_date->format('d M Y') }}
                        </span>
                    </div>
                    @endif

                    <!-- Konten -->
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 group-hover:text-blue-600 transition">
                            {{ $announcement->title }}
                        </h3>

                        <div class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-3 prose max-w-none">
                            {!! $announcement->content !!}
                        </div>

                        <span class="text-blue-600 font-semibold text-sm hover:underline">
                            Baca selengkapnya
                        </span>
                    </div>

                </div>
                @empty
                <p class="text-gray-600 dark:text-gray-400 col-span-full text-center">
                    Tidak ada pengumuman saat ini.
                </p>
                @endforelse

            </div>

        </div>
    </div>

    <!-- MODAL SECTION -->
    @foreach($announcements as $announcement)
    <div id="modal-{{ $announcement->id }}"
         class="fixed inset-0 hidden bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4 transition">

        <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-3xl shadow-xl overflow-hidden transform scale-95 opacity-0 modal-box transition">

            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                    {{ $announcement->title }}
                </h3>

                <button onclick="closeModal('modal-{{ $announcement->id }}')"
                    class="text-gray-500 hover:text-red-500 transition">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Gambar -->
            @if($announcement->image)
            <img src="{{ asset('storage/' . $announcement->image) }}"
                 class="w-full max-h-80 object-cover">
            @endif

            <!-- Isi modal -->
            <div class="p-6">
                <p class="text-sm text-gray-500 mb-3">
                    Diterbitkan pada: {{ $announcement->publish_date->format('d F Y') }}
                </p>

                <div class="text-gray-700 dark:text-gray-200 prose max-w-none">
                    {!! $announcement->content !!}
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button onclick="closeModal('modal-{{ $announcement->id }}')"
                        class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endforeach

</section>

<!-- SCRIPT -->
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        const box = modal.querySelector('.modal-box');
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
    }
</script>

@endsection