@extends('layouts.app')

@section('title', 'Detail Jadwal - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">

    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Jadwal Mengajar</h2>
                        <a href="{{ route('guru.schedules.index') }}"
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Informasi Jadwal -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Informasi Jadwal</h3>
                            <div class="space-y-3">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mata Pelajaran</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $schedule->subject->name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $schedule->class->name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hari</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-200 capitalize">{{ $schedule->day }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</p>
                                </div>

                            </div>
                        </div>

                        <!-- Daftar Siswa -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Daftar Siswa ({{ $schedule->class->students->count() }} siswa)</h3>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @forelse($schedule->class->students as $student)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded p-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $student->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">NIS: {{ $student->nis }}</p>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada siswa di kelas ini.</p>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Informasi Tambahan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dibuat Pada</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $schedule->created_at->format('d F Y H:i') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diubah Pada</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $schedule->updated_at->format('d F Y H:i') }}</p>
                            </div>  

                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</div>
@endsection
