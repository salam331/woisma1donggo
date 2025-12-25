@extends('layouts.app')

@section('title', 'Absensi Siswa')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Absensi per Mata Pelajaran</h1>
                    <div class="text-sm text-gray-500">
                        Klik card untuk melihat detail riwayat
                    </div>
                </div>

                @if($subjectsWithAttendance->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada data absensi</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada records absensi yang tersedia untuk mata pelajaran apapun.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($subjectsWithAttendance as $subjectData)
                        <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">

                            <!-- Accent Gradient -->
                            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>

                            <div class="p-6">

                                <!-- Header -->
                                <div class="flex items-start justify-between mb-5">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 leading-tight">
                                            {{ $subjectData['subject']->name }}
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            Rekap kehadiran siswa
                                        </p>
                                    </div>

                                    <a href="{{ route('siswa.attendances.show', $subjectData['subject']->id) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold
                                            rounded-full text-blue-700 bg-blue-100
                                            hover:bg-blue-200 focus:ring-2 focus:ring-blue-400 transition">
                                        Detail
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>

                                <!-- Percentage -->
                                <div class="flex items-end justify-between mb-4">
                                    <div>
                                        <span class="text-xs text-gray-500">Persentase Kehadiran</span>
                                        <div class="text-3xl font-extrabold text-green-600 leading-tight">
                                            {{ $subjectData['stats']['persentase_hadir'] }}%
                                        </div>
                                    </div>

                                    <div class="text-right text-xs text-gray-400">
                                        Total<br>
                                        <span class="font-semibold text-gray-700">
                                            {{ $subjectData['stats']['total'] }} pertemuan
                                        </span>
                                    </div>
                                </div>

                                <!-- Stats Grid -->
                                <div class="grid grid-cols-2 gap-3 text-sm mb-4">

                                    <div class="flex items-center gap-2 p-2 rounded-lg bg-green-50">
                                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                                        <span class="text-gray-600">Hadir</span>
                                        <span class="ml-auto font-bold text-green-700">
                                            {{ $subjectData['stats']['hadir'] }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2 p-2 rounded-lg bg-yellow-50">
                                        <span class="w-2.5 h-2.5 bg-yellow-500 rounded-full"></span>
                                        <span class="text-gray-600">Izin</span>
                                        <span class="ml-auto font-bold text-yellow-700">
                                            {{ $subjectData['stats']['izin'] }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2 p-2 rounded-lg bg-blue-50">
                                        <span class="w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                                        <span class="text-gray-600">Terlambat</span>
                                        <span class="ml-auto font-bold text-blue-700">
                                            {{ $subjectData['stats']['terlambat'] }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2 p-2 rounded-lg bg-red-50">
                                        <span class="w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                                        <span class="text-gray-600">Alpha</span>
                                        <span class="ml-auto font-bold text-red-700">
                                            {{ $subjectData['stats']['tidak_hadir'] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="space-y-1">
                                    <div class="flex h-2 rounded-full overflow-hidden bg-gray-200">
                                        @if($subjectData['stats']['total'] > 0)
                                            <div class="bg-green-500"
                                                style="width: {{ ($subjectData['stats']['hadir'] / $subjectData['stats']['total']) * 100 }}%"></div>
                                            <div class="bg-yellow-500"
                                                style="width: {{ ($subjectData['stats']['izin'] / $subjectData['stats']['total']) * 100 }}%"></div>
                                            <div class="bg-blue-500"
                                                style="width: {{ ($subjectData['stats']['terlambat'] / $subjectData['stats']['total']) * 100 }}%"></div>
                                            <div class="bg-red-500"
                                                style="width: {{ ($subjectData['stats']['tidak_hadir'] / $subjectData['stats']['total']) * 100 }}%"></div>
                                        @endif
                                    </div>

                                    <p class="text-[10px] text-gray-400">
                                        Visual proporsi kehadiran per status
                                    </p>
                                </div>

                            </div>
                        </div>

                        @endforeach
                    </div>

                    <!-- Summary Stats -->
                    <div class="mt-8 bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Keseluruhan</h2>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            @php
                            $totalStats = [
                                'hadir' => $subjectsWithAttendance->sum(fn($i) => $i['stats']['hadir']),
                                'izin' => $subjectsWithAttendance->sum(fn($i) => $i['stats']['izin']),
                                'terlambat' => $subjectsWithAttendance->sum(fn($i) => $i['stats']['terlambat']),
                                'tidak_hadir' => $subjectsWithAttendance->sum(fn($i) => $i['stats']['tidak_hadir']),
                                'total' => $subjectsWithAttendance->sum(fn($i) => $i['stats']['total']),
                            ];

                            $totalStats['persentase_hadir'] = $totalStats['total'] > 0
                                ? round(($totalStats['hadir'] / $totalStats['total']) * 100, 1)
                                : 0;
                            @endphp

                            <div class="text-center text-green-600 font-bold">{{ $totalStats['hadir'] }}<div class="text-sm text-gray-500">Hadir</div></div>
                            <div class="text-center text-yellow-600 font-bold">{{ $totalStats['izin'] }}<div class="text-sm text-gray-500">Izin</div></div>
                            <div class="text-center text-blue-600 font-bold">{{ $totalStats['terlambat'] }}<div class="text-sm text-gray-500">Terlambat</div></div>
                            <div class="text-center text-red-600 font-bold">{{ $totalStats['tidak_hadir'] }}<div class="text-sm text-gray-500">Tidak Hadir</div></div>
                            <div class="text-center font-bold">{{ $totalStats['total'] }}<div class="text-sm text-gray-500">Total</div></div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <span class="text-lg font-semibold text-gray-700">Persentase Kehadiran Keseluruhan: </span>
                            <span class="text-2xl font-bold text-green-600">{{ $totalStats['persentase_hadir'] }}%</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
