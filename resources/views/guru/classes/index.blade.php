
@extends('layouts.app')

@section('title', 'Kelas Saya')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Daftar Kelas yang Anda Ajar
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Berikut adalah kelas-kelas yang telah dibagikan oleh admin untuk Anda kelola.
                        </p>
                    </div>

                    @if($classes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($classes as $class)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $class->name }}
                                        </h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            Kelas {{ $class->grade_level }}
                                        </span>
                                    </div>

                                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                        @if($class->major)
                                            <p><strong>Jurusan:</strong> {{ $class->major }}</p>
                                        @endif
                                        <p><strong>Tahun Ajaran:</strong> {{ $class->academic_year }}</p>
                                        <p><strong>Kapasitas:</strong> {{ $class->capacity }} siswa</p>
                                        <p><strong>Jumlah Siswa:</strong> {{ $class->statistics['total_students'] }} siswa</p>
                                    </div>

                                    <!-- Statistics Cards -->
                                    <div class="mt-4 grid grid-cols-2 gap-3">
                                        <div class="bg-white dark:bg-gray-600 rounded p-3 text-center">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $class->statistics['total_schedules'] }}
                                            </div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                                Jadwal
                                            </div>
                                        </div>
                                        <div class="bg-white dark:bg-gray-600 rounded p-3 text-center">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $class->statistics['materials_count'] }}
                                            </div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                                Materi
                                            </div>
                                        </div>
                                        <div class="bg-white dark:bg-gray-600 rounded p-3 text-center">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $class->statistics['exams_count'] }}
                                            </div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                                Ujian
                                            </div>
                                        </div>
                                        <div class="bg-white dark:bg-gray-600 rounded p-3 text-center">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $class->students_count }}
                                            </div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                                Total Siswa
                                            </div>
                                        </div>
                                    </div>

                                    @if($class->description)
                                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $class->description }}
                                            </p>
                                        </div>
                                    @endif

                                    <div class="mt-4 flex flex-col space-y-2">
                                        <a href="{{ route('guru.classes.show', $class) }}"
                                           class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Lihat Detail Kelas
                                        </a>
                                        <a href="{{ route('guru.classes.students', $class) }}"
                                           class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            Kelola Siswa
                                        </a>
                                        <a href="{{ route('guru.attendances.index-by-class', $class) }}"
                                           class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                            </svg>
                                            Lihat Kehadiran
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada kelas</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Belum ada kelas yang dibagikan kepada Anda oleh admin.
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
