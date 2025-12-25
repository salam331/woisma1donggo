@extends('layouts.app')

@section('title', 'Detail Absensi - ' . $subject->name)

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <a href="{{ route('siswa.attendances.index') }}"
               class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Absensi
            </a>

            <h1 class="text-2xl font-bold text-gray-900">
                Detail Absensi – {{ $subject->name }}
            </h1>
            <p class="text-sm text-gray-500">
                Riwayat kehadiran siswa pada mata pelajaran ini
            </p>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT : TABLE -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm rounded-lg p-6">

                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Riwayat Absensi
                    </h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Status Kehadiran
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Guru
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Keterangan
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($attendances as $attendance)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        {{ $attendance->date->format('d/m/Y') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @php
                                            $statusMap = [
                                                'present' => ['Hadir', 'green'],
                                                'excused' => ['Izin', 'yellow'],
                                                'late'    => ['Terlambat', 'blue'],
                                                'absent'  => ['Tidak Hadir', 'red'],
                                            ];
                                            [$label, $color] = $statusMap[$attendance->status]
                                                ?? ['Tidak Diketahui', 'gray'];
                                        @endphp

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            bg-{{ $color }}-100 text-{{ $color }}-800">
                                            {{ $label }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        {{ $attendance->schedule->teacher->user->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $attendance->notes ?? '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        Belum ada data absensi
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(!$attendances->isEmpty())
                    <div class="mt-6">
                        {{ $attendances->links() }}
                    </div>
                    @endif

                </div>
            </div>

            <!-- RIGHT : SUMMARY -->
            <div class="space-y-6">

                <!-- Percentage Card -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">
                        Persentase Kehadiran
                    </h3>

                    <div class="flex items-end justify-between mb-4">
                        <span class="text-4xl font-bold text-green-600">
                            {{ $stats['persentase_hadir'] }}%
                        </span>
                        <span class="text-xs text-gray-500">
                            dari {{ $stats['total'] }} pertemuan
                        </span>
                    </div>

                    <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                        @if($stats['total'] > 0)
                            <div class="h-full bg-green-500"
                                 style="width: {{ ($stats['hadir'] / $stats['total']) * 100 }}%"></div>
                        @endif
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['hadir'] }}</div>
                        <div class="text-xs text-gray-600">Hadir</div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['izin'] }}</div>
                        <div class="text-xs text-gray-600">Izin</div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['terlambat'] }}</div>
                        <div class="text-xs text-gray-600">Terlambat</div>
                    </div>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $stats['tidak_hadir'] }}</div>
                        <div class="text-xs text-gray-600">Tidak Hadir</div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">
                        Keterangan Status
                    </h3>

                    <ul class="space-y-2 text-xs text-gray-600">
                        <li class="flex items-center">
                            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                            Hadir – siswa mengikuti pembelajaran
                        </li>
                        <li class="flex items-center">
                            <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                            Izin – tidak hadir dengan izin resmi
                        </li>
                        <li class="flex items-center">
                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                            Terlambat – hadir melewati jam pelajaran
                        </li>
                        <li class="flex items-center">
                            <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                            Tidak Hadir – tanpa keterangan
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
