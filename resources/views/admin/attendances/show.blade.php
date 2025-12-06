@extends('layouts.app')

@section('title', 'Detail Kehadiran Siswa')

@section('content')

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
        Detail Kehadiran Siswa
    </h2>
    <a href="{{ route('admin.attendances.student-history', ['studentId' => $attendance->student->id, 'subjectId' => $subject->id]) }}"
       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Kembali
    </a>
</div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Informasi Siswa -->
        <div>
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

        <!-- Informasi Kehadiran -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Informasi Kehadiran</h3>
            <div class="space-y-3">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mata Pelajaran</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $attendance->schedule->subject->name ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $attendance->date->format('d F Y') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <p class="mt-1">

                        @if($attendance->status == 'present')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hadir</span>
                        @elseif($attendance->status == 'absent')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Tidak Hadir</span>
                        @elseif($attendance->status == 'late')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Terlambat</span>
                        @elseif($attendance->status == 'excused')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Izin</span>
                        @endif

                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $attendance->notes ?? '-' }}</p>
                </div>

            </div>
        </div>

    </div>

    <!-- Informasi Tambahan -->
    <div class="mt-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">Informasi Tambahan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dibuat Pada</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $attendance->created_at->format('d F Y H:i') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diubah Pada</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $attendance->updated_at->format('d F Y H:i') }}</p>
            </div>

        </div>
    </div>

    <!-- Button Aksi -->
    <div class="mt-6 flex space-x-2 justify-end">
        <a href="{{ route('admin.attendances.edit', $attendance) }}"
           class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            Edit
        </a>

        <form method="POST" action="{{ route('admin.attendances.destroy', $attendance) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                onclick="return confirm('Apakah Anda yakin ingin menghapus data kehadiran ini?')">
                Hapus
            </button>
        </form>
    </div>

</div>

@endsection
