@extends('layouts.app')

@section('title', 'Detail Materi - ' . $material->title)

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">

    {{-- HEADER --}}
    <header class="sticky top-0 z-30 bg-white dark:bg-gray-800 border-b dark:border-gray-700 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-file-alt text-blue-600"></i>
                Detail Materi
            </h1>

            <a href="{{ route('guru.materials.index') }}"
               class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl font-semibold transition">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-6 py-8">

        {{-- ALERT --}}
        @foreach (['success' => 'green', 'error' => 'red'] as $key => $color)
            @if(session($key))
                <div class="mb-6 bg-{{ $color }}-100 border border-{{ $color }}-300 text-{{ $color }}-800 px-4 py-3 rounded-xl">
                    {{ session($key) }}
                </div>
            @endif
        @endforeach

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT: DETAIL --}}
            <section class="lg:col-span-2 space-y-8">

                {{-- INFO UTAMA --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700 p-6 shadow-sm">

                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $material->title }}
                        </h2>

                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            {{ $material->is_public
                                ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' }}">
                            <i class="fas fa-{{ $material->is_public ? 'eye' : 'lock' }} mr-1"></i>
                            {{ $material->is_public ? 'Publik' : 'Private' }}
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <span><i class="far fa-calendar mr-1"></i>{{ $material->created_at->format('d F Y, H:i') }}</span>
                        <span><i class="fas fa-user mr-1"></i>{{ $material->teacher->user->name ?? 'Unknown' }}</span>
                        <span><i class="fas fa-users mr-1"></i>{{ $material->class->name ?? 'N/A' }}</span>
                        <span><i class="fas fa-book mr-1"></i>{{ $material->subject->name ?? 'N/A' }}</span>
                    </div>

                    @if($material->description)
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($material->description)) !!}
                        </div>
                    @endif
                </div>

                {{-- FILE PREVIEW --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700 p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-file mr-2"></i>File Materi
                    </h3>

                    @if($material->mime_type && str_starts_with($material->mime_type, 'image/'))
                        <img src="{{ asset('storage/'.$material->file_path) }}"
                             alt="{{ $material->file_name }}"
                             class="rounded-xl border dark:border-gray-700 max-h-96 mx-auto cursor-zoom-in transition hover:scale-[1.02]">
                    @elseif($material->mime_type === 'application/pdf')
                        <div class="flex flex-col items-center justify-center bg-red-50 dark:bg-red-900/30 rounded-xl p-8">
                            <i class="fas fa-file-pdf text-red-500 text-5xl mb-3"></i>
                            <p class="text-sm text-red-700 dark:text-red-300">File PDF</p>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-xl p-8">
                            <i class="fas fa-file text-gray-500 text-5xl mb-3"></i>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ strtoupper(pathinfo($material->file_name, PATHINFO_EXTENSION)) }}
                            </p>
                        </div>
                    @endif
                </div>

            </section>

            {{-- RIGHT: AKSI & INFO --}}
            <aside class="space-y-6">

                {{-- FILE INFO --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Informasi File</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between"><span>Nama</span><span class="font-medium">{{ $material->file_name }}</span></div>
                        <div class="flex justify-between"><span>Tipe</span><span>{{ $material->mime_type }}</span></div>
                        <div class="flex justify-between"><span>Ukuran</span><span>{{ number_format($material->file_size / 1024, 1) }} KB</span></div>
                    </div>
                </div>

                {{-- AKSI --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Aksi</h3>

                    <div class="space-y-3">
                        <a href="{{ route('guru.materials.download', $material) }}"
                           class="block text-center bg-green-600 hover:bg-green-700 text-white py-2 rounded-xl font-semibold transition">
                            <i class="fas fa-download mr-2"></i>Download
                        </a>

                        <a href="{{ route('guru.materials.edit', $material) }}"
                           class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl font-semibold transition">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>

                        <form method="POST" action="{{ route('guru.materials.destroy', $material) }}">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus materi ini?')"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-xl font-semibold transition">
                                <i class="fas fa-trash mr-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>

                {{-- STAT --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl border dark:border-gray-700 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Statistik</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span>Dibuat</span><span>{{ $material->created_at->diffForHumans() }}</span></div>
                        <div class="flex justify-between"><span>Diubah</span><span>{{ $material->updated_at->diffForHumans() }}</span></div>
                    </div>
                </div>

            </aside>
        </div>
    </main>
</div>
@endsection
