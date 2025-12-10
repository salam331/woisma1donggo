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
                            <div class="flex items-center justify-center gap-x-4">

    {{-- Tombol Lihat (Biru terang) --}}
    <a href="{{ route('admin.attendances.show', ['attendance' => $attendance->id, 'subjectId' => $subject->id]) }}"
        class="p-2 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 hover:text-blue-900 transition-colors duration-200 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
    </a>

    {{-- Tombol Edit (Kuning terang) --}}
    <a href="{{ route('admin.attendances.edit', $attendance) }}"
        class="p-2 rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 transition-colors duration-200 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
    </a>

    {{-- Tombol Hapus (Merah terang) --}}
    <form method="POST" action="{{ route('admin.attendances.destroy', $attendance) }}" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit"
            onclick="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?')"
            class="p-2 rounded-full bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-900 transition-colors duration-200 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
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