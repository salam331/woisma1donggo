@extends('layouts.app')

@section('title', 'Detail Materi: ' . $material->title)

@section('content')

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                    Detail Materi: {{ $material->title }}
                </h2>

                <div class="flex space-x-2">
                    <a href="{{ route('admin.materials.edit', $material) }}"
                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Edit Materi
                    </a>

                    <a href="{{ route('admin.materials.download', $material) }}"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Download File
                    </a>

                    <a href="{{ route('admin.materials.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- INFORMASI MATERI --}}
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Materi</h3>

                    <div class="space-y-4">

                        {{-- Thumbnail --}}
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16">
                                @if(str_contains($material->file_type, 'image'))
                                    <img class="h-16 w-16 rounded-full object-cover"
                                        src="{{ asset('storage/' . $material->file_path) }}" alt="">
                                @elseif(str_contains($material->file_type, 'pdf'))
                                    <div class="h-16 w-16 bg-red-100 rounded-full flex items-center justify-center">
                                        <span class="text-2xl font-bold text-red-600">PDF</span>
                                    </div>
                                @elseif(str_contains($material->file_type, 'video'))
                                    <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-2xl font-bold text-blue-600">VID</span>
                                    </div>
                                @else
                                    <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <span class="text-2xl font-bold text-gray-600">DOC</span>
                                    </div>
                                @endif
                            </div>

                            <div class="ml-4">
                                <div class="text-2xl font-medium text-gray-900 dark:text-white">
                                    {{ $material->title }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $material->subject->name ?? '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- Detail List --}}
                        <div class="border-t pt-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Judul Materi</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $material->title }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mata Pelajaran</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $material->subject->name ?? '-' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Guru Pengajar</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $material->teacher->name ?? '-' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipe File</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $material->file_type }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ukuran File</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ number_format(Storage::disk('public')->size($material->file_path) / 1024, 1) }}
                                        KB
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $material->created_at->format('d F Y H:i') }}
                                    </dd>
                                </div>

                            </dl>
                        </div>

                        {{-- Deskripsi --}}
                        @if($material->description)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $material->description }}
                                </dd>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- PREVIEW FILE --}}
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Preview File</h3>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">

                        @if(str_contains($material->file_type, 'image'))
                            <img src="{{ asset('storage/' . $material->file_path) }}" alt="{{ $material->title }}"
                                class="w-full h-auto rounded-lg">

                        @elseif(str_contains($material->file_type, 'pdf'))
                            <div class="text-center">
                                <div class="h-32 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                                    <span class="text-4xl font-bold text-red-600">PDF</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300">File PDF tidak dapat dipreview di browser</p>
                                <a href="{{ route('admin.materials.download', $material) }}"
                                    class="inline-block mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Download untuk Melihat
                                </a>
                            </div>

                        @elseif(str_contains($material->file_type, 'video'))
                            <video controls class="w-full rounded-lg">
                                <source src="{{ asset('storage/' . $material->file_path) }}" type="{{ $material->file_type }}">
                                Browser Anda tidak mendukung tag video.
                            </video>

                        @else
                            <div class="text-center">
                                <div class="h-32 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                                    <span class="text-4xl font-bold text-gray-600">DOC</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300">File dokumen tidak dapat dipreview di browser</p>
                                <a href="{{ route('admin.materials.download', $material) }}"
                                    class="inline-block mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Download untuk Melihat
                                </a>
                            </div>

                        @endif

                    </div>

                    {{-- QUICK ACTIONS --}}
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Aksi Cepat</h4>

                        <div class="space-y-2">
                            <a href="{{ route('admin.materials.edit', $material) }}"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Edit Informasi Materi
                            </a>

                            <a href="{{ route('admin.materials.download', $material) }}"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Download File Materi
                            </a>

                            <button
                                class="block w-full text-left px-4 py-2 text-sm text-red-700 dark:text-red-400 bg-white dark:bg-gray-800 border border-red-300 dark:border-red-600 rounded-md hover:bg-red-50 dark:hover:bg-gray-700">
                                Hapus Materi
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection