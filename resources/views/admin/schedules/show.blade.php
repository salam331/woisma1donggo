<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Jadwal Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Jadwal</h3>

                            <div class="space-y-4">

                                <div class="border-t pt-4">
                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">

                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">ID</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $schedule->id }}</dd>
                                        </div>

                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Hari</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{-- nama hari dengan format indonesian--}}
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
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $schedule->start_time->format('H:i') }}
                                            </dd>
                                        </div>

                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Jam Selesai</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $schedule->end_time->format('H:i') }}
                                            </dd>
                                        </div>

                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Dibuat Pada</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $schedule->created_at->format('d/m/Y H:i') }}
                                            </dd>
                                        </div>

                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $schedule->updated_at->format('d/m/Y H:i') }}
                                            </dd>
                                        </div>

                                    </dl>
                                </div>

                            </div>
                        </div>

                        <!-- Relational Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Relasi</h3>

                            <div class="bg-gray-50 rounded-lg p-4 space-y-4">

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $schedule->class->name }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Mata Pelajaran</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $schedule->subject->name }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Guru</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $schedule->teacher->name }}
                                    </dd>
                                </div>

                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Aksi Cepat</h4>

                                <div class="space-y-2">
                                    <a href="{{ route('admin.schedules.edit', $schedule) }}"
                                       class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Edit Jadwal
                                    </a>

                                    <button
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Lihat Kelas Terkait
                                    </button>

                                    <button
                                        class="block w-full text-left px-4 py-2 text-sm text-red-700 bg-white border border-red-300 rounded-md hover:bg-red-50">
                                        Nonaktifkan Jadwal
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
