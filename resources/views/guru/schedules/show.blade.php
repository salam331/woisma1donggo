@extends('layouts.app')

@section('title', 'Detail Jadwal - Guru Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800 p-6">

    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Detail Jadwal Mengajar
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Informasi lengkap jadwal, kelas, dan daftar siswa
                </p>
            </div>
            <a href="{{ route('guru.schedules.index') }}"
               class="inline-flex items-center gap-2 bg-gray-700 hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow transition">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg ring-1 ring-black/5 dark:ring-white/10 p-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Informasi Jadwal -->
                <div class="lg:col-span-1 space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                        <span class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        Informasi Jadwal
                    </h2>

                    <div class="space-y-5 text-sm">

                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Mata Pelajaran</p>
                            <p class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                {{ $schedule->subject->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Kelas</p>
                            <p class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                {{ $schedule->class->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500 dark:text-gray-400 mb-1">Hari</p>
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold
                                bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100 shadow-sm">
                                {{ $schedule->day_indo }}
                            </span>
                        </div>

                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Waktu Mengajar</p>
                            <p class="text-base font-bold text-gray-900 dark:text-gray-100 tracking-wide">
                                {{ $schedule->start_time->format('H:i') }}
                                <span class="mx-1 text-gray-400">–</span>
                                {{ $schedule->end_time->format('H:i') }}
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Daftar Siswa -->
                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                            <span class="p-2 rounded-lg bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                                <i class="fas fa-users"></i>
                            </span>
                            Daftar Siswa
                        </h2>
                        <span class="text-xs font-medium px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                            {{ $schedule->class->students->count() }} siswa
                        </span>
                    </div>

                    <div class="border dark:border-gray-700 rounded-xl divide-y dark:divide-gray-700 max-h-96 overflow-y-auto">

                        @forelse($schedule->class->students as $student)
                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center font-bold text-indigo-700 dark:text-indigo-300">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $student->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            NIS: {{ $student->nis }}
                                        </p>
                                    </div>
                                </div>
                                <i class="fas fa-user-check text-gray-400"></i>
                            </div>
                        @empty
                            <div class="p-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada siswa di kelas ini.
                            </div>
                        @endforelse

                    </div>
                </div>

            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-10 border-t dark:border-gray-700 pt-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                    <span class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300">
                        <i class="fas fa-info-circle"></i>
                    </span>
                    Informasi Tambahan
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <p class="text-gray-500 dark:text-gray-400">Dibuat Pada</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $schedule->created_at->format('d F Y, H:i') }}
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <p class="text-gray-500 dark:text-gray-400">Terakhir Diubah</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100 mt-1">
                            {{ $schedule->updated_at->format('d F Y, H:i') }}
                        </p>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
