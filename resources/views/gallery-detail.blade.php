@extends('layouts.guest')

@section('header')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        Detail Galeri
    </h2>

    <a href="{{ route('gallery') }}"
       class="bg-gradient-to-r from-gray-600 to-gray-800 hover:from-gray-700 hover:to-gray-900 text-white px-4 py-2 rounded-lg shadow-md transition">
       Kembali
    </a>
</div>
@endsection

@section('content')
<div class="py-12 mt-20" x-data="{ open: false, imgSrc: '', imgName: '' }">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        <!-- Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <div class="p-8">

                <!-- Judul -->
                <div class="border-b pb-4 mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $gallery->title }}</h1>
                    <p class="text-gray-500 mt-1">Detail lengkap galeri</p>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Info -->
                    <div class="space-y-6">

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Judul</h3>
                            <p class="text-gray-800 text-lg mt-1">{{ $gallery->title }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Deskripsi</h3>
                            <p class="text-gray-700 mt-1 leading-relaxed">
                                {{ $gallery->description ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Kategori</h3>
                            <span class="inline-block mt-2 bg-blue-100 text-blue-800 px-3 py-1 text-xs rounded-full">
                                {{ $gallery->category ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Tanggal Event</h3>
                            <p class="mt-1 text-gray-700">
                                {{ $gallery->event_date ? $gallery->event_date->format('d M Y') : '-' }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Dibuat Pada</h3>
                            <p class="text-gray-700 mt-1">
                                {{ $gallery->created_at->format('d M Y H:i') }}
                            </p>
                        </div>

                    </div>

                    <!-- Gambar -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-2">
                            Gambar Utama
                        </h3>

                        <div class="rounded-xl overflow-hidden shadow-md cursor-pointer"
                             @click="open = true; imgSrc='{{ asset('storage/'.$gallery->image_path) }}'; imgName='{{ $gallery->title }}'">
                            
                            <img src="{{ asset('storage/' . $gallery->image_path) }}"
                                 alt="{{ $gallery->title }}"
                                 class="w-full h-64 object-cover hover:scale-105 transition duration-300">
                        </div>

                        @if($gallery->additional_images)
                        <div class="mt-6">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">
                                Gambar Tambahan
                            </h4>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                                @foreach($gallery->additional_images as $additional)
                                    <div class="rounded-lg border shadow-sm overflow-hidden cursor-pointer"
                                         @click="open = true; imgSrc='{{ asset('storage/'.$additional['image_path']) }}'; imgName='{{ $additional['description'] ?? 'Image' }}'">
                                        
                                        <img src="{{ asset('storage/' . $additional['image_path']) }}"
                                             alt="{{ $additional['description'] ?? 'Additional Image' }}"
                                             class="w-full h-28 object-cover hover:scale-110 transition duration-300">

                                        @if($additional['description'])
                                        <p class="text-xs text-gray-600 p-2">{{ $additional['description'] }}</p>
                                        @endif
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        @endif

                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- Modal -->
    <div x-show="open"
         x-transition.opacity
         class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4">

        <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full overflow-hidden" x-transition>
            
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold" x-text="imgName"></h3>
                <button @click="open = false" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
            </div>

            <div class="p-4">
                <img :src="imgSrc" class="w-full max-h-[75vh] object-contain rounded-lg">
            </div>

            <div class="p-4 border-t flex justify-end">
                <a :href="imgSrc" download
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                   Download Gambar
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
