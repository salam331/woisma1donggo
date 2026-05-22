@extends('layouts.app')

@section('title', 'Rekap Kehadiran Siswa Berdasarkan Kelas')

@section('content')

    <div>
        {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
    

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                        Rekap Kehadiran Siswa Berdasarkan Kelas
                    </h2>

                    <div class="flex space-x-2">
                        <a href="{{ route('admin.attendances.summary') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Lihat Ringkasan
                        </a>
                        <a href="{{ route('admin.attendances.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Kehadiran
                        </a>
                    </div>
                </div>
                <!-- Classes Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-responsive">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Kelas
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Total Kehadiran
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Hadir
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Tidak Hadir
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Terlambat
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Izin
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Persentase Hadir
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($classSummaries as $summary)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td data-label="Kelas"
                                        class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $summary['class']->name }}
                                    </td>

                                    <td data-label="Total Kehadiran" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $summary['total_attendances'] }}
                                    </td>

                                    <td data-label="Hadir" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $summary['present_count'] }}
                                    </td>

                                    <td data-label="Tidak Hadir" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $summary['absent_count'] }}
                                    </td>

                                    <td data-label="Terlambat" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $summary['late_count'] }}
                                    </td>

                                    <td data-label="Izin" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $summary['excused_count'] }}
                                    </td>

                                    <td data-label="Persentase Hadir"
                                        class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $summary['present_percentage'] }}%
                                    </td>

                                    <td data-label="Aksi" class="px-6 py-4 text-center text-sm font-medium">
                                        <!-- DESKTOP -->
                                        <div class="flex items-center justify-center gap-x-4">
                                            {{-- <a href="{{ route('admin.attendances.index-by-class', $summary['class']->id) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                                Lihat
                                            </a> --}}
                                            <a href="{{ route('admin.attendances.index-by-class', $summary['class']->id) }}"
                                            class="p-2 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 hover:text-blue-900 transition-colors duration-200 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            </a>
                                        </div>

                                        <!-- MOBILE -->
                                        {{-- <div class="mobile-actions sm:hidden">
                                            <a href="{{ route('admin.attendances.index-by-class', $summary['class']->id) }}"
                                                class="px-3 py-1 text-xs rounded bg-blue-500 text-white">Lihat</a>
                                        </div> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                        Tidak ada data kelas ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>


                    </table>
                </div>

            </div>
        </div>

@endsection