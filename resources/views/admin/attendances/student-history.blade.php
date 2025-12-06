@extends('layouts.app')

@section('title', 'Histori Absensi Siswa')

@section('content')

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 overflow-x-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Histori Absensi Siswa: {{ $student->name }} - Mata Pelajaran: {{ $subject->name }}
            </h2>

            <a href="{{ route('admin.attendances.index-by-subject', ['classId' => $student->class->id, 'subjectId' => $subject->id]) }}"
                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <!-- Table / Mobile Cards -->
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-responsive">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Tanggal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Catatan
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($attendances as $attendance)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg mb-3">
                        <td data-label="Tanggal" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                            {{ $attendance->date->format('d F Y') }}
                        </td>
                        <td data-label="Status" class="px-6 py-4">
                            @if($attendance->status == 'present')
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hadir</span>
                            @elseif($attendance->status == 'absent')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Tidak
                                    Hadir</span>
                            @elseif($attendance->status == 'late')
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Terlambat</span>
                            @elseif($attendance->status == 'excused')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Izin</span>
                            @endif
                        </td>
                        <td data-label="Catatan" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-300">
                            {{ $attendance->notes ?? '-' }}
                        </td>
                        <td data-label="Aksi" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                            <div class="mobile-actions sm:flex justify-center gap-2">
                                <a href="{{ route('admin.attendances.show', ['attendance' => $attendance->id, 'subjectId' => $subject->id]) }}"
                                    class="px-3 py-1 text-xs rounded bg-indigo-500 text-white hover:bg-indigo-600">Lihat</a>
                                <a href="{{ route('admin.attendances.edit', $attendance) }}"
                                    class="px-3 py-1 text-xs rounded bg-blue-500 text-white hover:bg-blue-600">Edit</a>
                                <form method="POST" action="{{ route('admin.attendances.destroy', $attendance) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 text-xs rounded bg-red-500 text-white hover:bg-red-600"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada data absensi ditemukan untuk siswa ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($attendances->hasPages())
            <div class="mt-6">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>

@endsection