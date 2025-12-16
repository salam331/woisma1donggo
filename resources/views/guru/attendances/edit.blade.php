@extends('layouts.app')

@section('title', 'Edit Kehadiran - Guru')

@section('content')

    <div class="p-6">
        <div class="max-w-4xl mx-auto">

            <!-- CARD -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <!-- HEADER -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Edit Kehadiran: {{ $attendance->student->name }}
                    </h2>

                    <a href="{{ route('guru.attendances.show', $attendance) }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('guru.attendances.update', $attendance) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- LEFT COLUMN - Info yang tidak bisa diedit -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Informasi Siswa</h3>
                                
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Siswa</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $attendance->student->name }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIS</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $attendance->student->nis }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $attendance->schedule->class->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Informasi Jadwal</h3>
                                
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mata Pelajaran</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $attendance->schedule->subject->name ?? '-' }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Jadwal</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $attendance->date->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN - Field yang bisa diedit -->
                        <div class="space-y-4">

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status Kehadiran
                                </label>
                                <select id="status" name="status" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                                           focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Status</option>

                                    <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Hadir</option>
                                    <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
                                    <option value="late" {{ old('status', $attendance->status) == 'late' ? 'selected' : '' }}>
                                        Terlambat</option>
                                    <option value="excused" {{ old('status', $attendance->status) == 'excused' ? 'selected' : '' }}>Izin</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Catatan (Opsional)
                                </label>
                                <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                             bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                                             focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes', $attendance->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Info Tambahan -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Informasi Edit</h4>
                                <div class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                                    <p>Dibuat: {{ $attendance->created_at->format('d F Y H:i') }}</p>
                                    <p>Diubah: {{ $attendance->updated_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-end mt-6 space-x-2">
                        <a href="{{ route('guru.attendances.show', $attendance) }}"
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Kehadiran
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
