@extends('layouts.app')

@section('title', 'Materi Pembelajaran - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    {{-- @include('components.sidebar-teacher') --}}

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        {{-- <header class="bg-white dark:bg-gray-800 shadow-sm border-b dark:border-gray-700">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Materi Pembelajaran</h1>
                    <a href="{{ route('guru.materials.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Upload Materi
                    </a>
                </div>
            </div>
        </header> --}}

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                    @if($materials->count() > 0)
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($materials as $material)
                            <div class="border dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition duration-200">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                            {{ $material->title }}
                                        </h3>

                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span>{{ $material->created_at->format('d M Y') }}</span>
                                            <span>{{ $material->subject->name ?? 'N/A' }}</span>
                                            <span>{{ $material->class->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    @if($material->is_public)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Publik</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Private</span>
                                    @endif
                                </div>

                                @if($material->description)
                                    <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                                        {{ Str::limit($material->description, 100) }}
                                    </p>
                                @endif


                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <span>{{ $material->file_name ?? 'N/A' }}</span>
                                    <span>{{ $material->file_size ? number_format($material->file_size / 1024, 1) . ' KB' : 'N/A' }}</span>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('guru.materials.show', $material) }}"
                                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center px-3 py-2 rounded text-sm font-medium transition duration-200">
                                        Lihat
                                    </a>
                                    <a href="{{ route('guru.materials.download', $material) }}"
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm font-medium transition duration-200">
                                        <i class="fas fa-download">Unduh</i>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $materials->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-file-upload text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada materi</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-6">Anda belum mengupload materi pembelajaran.</p>
                            <a href="{{ route('guru.materials.create') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                                Upload Materi Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
