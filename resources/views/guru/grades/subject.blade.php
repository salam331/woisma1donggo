@extends('layouts.app')

@section('title', 'Nilai ' . $subject->name . ' - Kelas ' . $class->name . ' - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('guru.grades.class', $class->id) }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Kelas {{ $class->name }}
                    </a>
                </div>

                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Nilai {{ $subject->name }} - Kelas {{ $class->name }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Pilih ujian untuk melihat dan mengelola nilai siswa
                    </p>
                </div>

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
                    @if($exams->count() > 0)
                        <div class="space-y-4">
                            @foreach($exams as $exam)
                            <div class="border dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                            {{ $exam->title }}
                                        </h3>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                            <span>Tanggal: {{ $exam->exam_date->format('d M Y') }}</span>
                                            <span>Jenis: {{ ucfirst($exam->type ?? 'N/A') }}</span>
                                            @if($exam->is_published)
                                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Published</span>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Draft</span>
                                            @endif
                                        </div>
                                        @if($exam->description)
                                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                                {{ Str::limit($exam->description, 150) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <a href="{{ route('guru.grades.exam', [$class->id, $subject->id, $exam->id]) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-200">
                                            Lihat Nilai
                                        </a>
                                        <a href="{{ route('guru.grades.edit-exam', [$class->id, $subject->id, $exam->id]) }}"
                                           class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded text-sm font-medium transition duration-200">
                                            Edit Nilai
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-file-alt text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada ujian</h3>
                            <p class="text-gray-500 dark:text-gray-400">Belum ada ujian yang dibuat untuk mata pelajaran ini.</p>
                            <a href="{{ route('guru.exams.create', ['class' => $class->id, 'subject' => $subject->id]) }}"
                               class="inline-flex items-center mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                <i class="fas fa-plus mr-2"></i>
                                Buat Ujian Baru
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

