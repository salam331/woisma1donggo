@extends('layouts.app')

@section('title', 'Ringkasan Kehadiran Siswa - Guru')

@section('content')

    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
        <div class="p-4 sm:p-6">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                    Ringkasan Kehadiran Siswa - Kelas yang Anda Ajar
                </h2>

                <a href="{{ route('guru.attendances.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded w-full sm:w-auto text-center">
                    Kembali
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kelas</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalClasses }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Jadwal</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalSchedules }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kehadiran</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalAttendance }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Persentase Hadir</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $attendancePercentage }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Status Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold text-white">H</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-700 dark:text-green-300">Hadir</p>
                            <p class="text-lg font-semibold text-green-800 dark:text-green-200">{{ $presentCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold text-white">T</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-700 dark:text-red-300">Tidak Hadir</p>
                            <p class="text-lg font-semibold text-red-800 dark:text-red-200">{{ $absentCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold text-white">L</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-700 dark:text-yellow-300">Terlambat</p>
                            <p class="text-lg font-semibold text-yellow-800 dark:text-yellow-200">{{ $lateCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold text-white">I</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-700 dark:text-blue-300">Izin</p>
                            <p class="text-lg font-semibold text-blue-800 dark:text-blue-200">{{ $excusedCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classes Table -->
            <div class="overflow-x-auto">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Detail Kelas yang Anda Ajar</h3>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                Kelas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                Jumlah Jadwal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                Mata Pelajaran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($teacherClasses as $class)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4" data-label="Kelas">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $class->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $class->grade_level }} {{ $class->major ? '(' . $class->major . ')' : '' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4" data-label="Jumlah Jadwal">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $class->schedules->count() }}
                                    </span>
                                </td>

                                <td class="px-6 py-4" data-label="Mata Pelajaran">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($class->schedules->unique('subject_id') as $schedule)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $schedule->subject->name ?? 'N/A' }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="px-6 py-4" data-label="Aksi">
                                    <a href="{{ route('guru.attendances.index-by-class', $class->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 px-3 rounded">
                                        Lihat Absensi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Anda belum memiliki jadwal mengajar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Monthly Statistics -->
            @if(isset($monthlyStats))
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Statistik Bulan Ini</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                        <p class="text-sm text-green-700 dark:text-green-300">Hadir</p>
                        <p class="text-xl font-semibold text-green-800 dark:text-green-200">{{ $monthlyStats['present'] ?? 0 }}</p>
                    </div>
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                        <p class="text-sm text-red-700 dark:text-red-300">Tidak Hadir</p>
                        <p class="text-xl font-semibold text-red-800 dark:text-red-200">{{ $monthlyStats['absent'] ?? 0 }}</p>
                    </div>
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                        <p class="text-sm text-yellow-700 dark:text-yellow-300">Terlambat</p>
                        <p class="text-xl font-semibold text-yellow-800 dark:text-yellow-200">{{ $monthlyStats['late'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                        <p class="text-sm text-blue-700 dark:text-blue-300">Izin</p>
                        <p class="text-xl font-semibold text-blue-800 dark:text-blue-200">{{ $monthlyStats['excused'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

@endsection
