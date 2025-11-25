@extends('layouts.app')

@section('title', 'Detail Jadwal')

@section('content')
    <div>
        {{-- Content Box --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Detail Jadwal
                    </h2>

                    <div class="flex space-x-2">
                        <a href="{{ route('admin.schedules.edit', $schedule) }}"
                            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Edit Jadwal
                        </a>

                        <a href="{{ route('admin.schedules.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Informasi Jadwal --}}
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Informasi Jadwal</h3>

                        <div class="space-y-4 border-t pt-4">

                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $schedule->id }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Hari</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        @php
                                            $dayTranslations = [
                                                'monday' => 'Senin',
                                                'tuesday' => 'Selasa',
                                                'wednesday' => 'Rabu',
                                                'thursday' => 'Kamis',
                                                'friday' => 'Jumat',
                                                'saturday' => 'Sabtu',
                                                'sunday' => 'Minggu',
                                            ];
                                        @endphp
                                        {{ $dayTranslations[$schedule->day] ?? $schedule->day }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Jam Mulai</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $schedule->start_time->format('H:i') }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Jam Selesai</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $schedule->end_time->format('H:i') }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dibuat Pada</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $schedule->created_at->format('d/m/Y H:i') }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $schedule->updated_at->format('d/m/Y H:i') }}
                                    </dd>
                                </div>

                            </dl>

                        </div>
                    </div>

                    {{-- Informasi Relasi --}}
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Informasi Relasi</h3>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-4">

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $schedule->class->name }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Mata Pelajaran</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $schedule->subject->name }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Guru</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $schedule->teacher->name }}
                                </dd>
                            </div>

                        </div>

                        {{-- Aksi Cepat --}}
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-200 mb-3">Aksi Cepat</h4>

                            <div class="space-y-2">

                                <a href="{{ route('admin.schedules.edit', $schedule) }}"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                                    Edit Jadwal
                                </a>

                                <button
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                                    Lihat Kelas Terkait
                                </button>

                                <button
                                    class="block w-full text-left px-4 py-2 text-sm text-red-700 dark:text-red-300 bg-white dark:bg-gray-800 border border-red-300 rounded-md hover:bg-red-50 dark:hover:bg-red-600/20">
                                    Nonaktifkan Jadwal
                                </button>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection