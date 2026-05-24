@extends('layouts.app')

@section('title', 'Materi Pembelajaran - Guru Dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
    {{-- @include('components.sidebar-teacher') --}}

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b dark:border-gray-700">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Materi Pembelajaran</h1>
                    <a href="{{ route('guru.materials.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Upload Materi
                    </a>
                </div>
            </div>
        </header>

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

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border dark:border-gray-700 p-6">

    @if($materials->count() > 0)

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @foreach($materials as $material)

                <div
                    class="group relative bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-2xl p-6
                           transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">

                    {{-- Badge Public / Private --}}
                    <div class="absolute top-4 right-4">
                        @if($material->is_public)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                         bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
                                Publik
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                         bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                Private
                            </span>
                        @endif
                    </div>

                    {{-- Judul --}}
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                        {{ $material->title }}
                    </h3>

                    {{-- Meta --}}
                    <div class="flex flex-wrap justify-between items-center gap-x-4 gap-y-1 text-xs text-gray-500 dark:text-gray-400 mb-4">
                        <span>
                            <i class="far fa-calendar mr-1"></i>
                            {{ $material->created_at->format('d M Y') }}
                        </span>
                        <span>
                            <i class="fas fa-book mr-1"></i>
                            {{ $material->subject->name ?? 'N/A' }}
                        </span>
                        <span>
                            <i class="fas fa-users mr-1"></i>
                            {{ $material->class->name ?? 'N/A' }}
                        </span>
                    </div>

                    {{-- Deskripsi --}}
                    @if($material->description)
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                            {{ $material->description }}
                        </p>
                    @endif

                    {{-- File Info --}}
                    <div
                        class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400
                               border-t dark:border-gray-700 pt-3 mb-4">
                        <span class="truncate max-w-[65%]">
                            <i class="far fa-file mr-1"></i>
                            {{ $material->file_name ?? 'N/A' }}
                        </span>
                        <span>
                            {{ $material->file_size
                                ? number_format($material->file_size / 1024, 1) . ' KB'
                                : 'N/A' }}
                        </span>
                    </div>

                    {{-- Action --}}
                    <div class="flex gap-2">
                        <a href="{{ route('guru.materials.show', $material) }}"
                           class="flex-1 inline-flex items-center justify-center gap-1
                                  bg-blue-600 hover:bg-blue-700 text-white
                                  px-3 py-2 rounded-lg text-sm font-semibold transition">
                            <i class="fas fa-eye"></i>
                            Lihat
                        </a>

                        <a href="{{ route('guru.materials.download', $material) }}"
                           class="inline-flex items-center justify-center
                                  bg-green-600 hover:bg-green-700 text-white
                                  px-3 py-2 rounded-lg text-sm font-semibold transition">
                            <i class="fas fa-download">Unduh</i>
                        </a>
                    </div>

                </div>

            @endforeach

        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $materials->links() }}
        </div>

    @else

        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="mb-6">
                <i class="fas fa-file-upload text-6xl text-gray-300 dark:text-gray-600"></i>
            </div>

            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                Belum Ada Materi
            </h3>

            <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md">
                Anda belum mengunggah materi pembelajaran. Mulai dengan mengunggah materi pertama Anda.
            </p>

            <a href="{{ route('guru.materials.create') }}"
               class="inline-flex items-center gap-2
                      bg-blue-600 hover:bg-blue-700 text-white
                      px-6 py-3 rounded-xl font-semibold transition">
                <i class="fas fa-upload"></i>
                Upload Materi
            </a>
        </div>

    @endif

</div>

            </div>
        </main>
    </div>
</div>
@endsection
