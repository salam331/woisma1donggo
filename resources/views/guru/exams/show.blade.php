@extends('layouts.app')

@section('title', 'Detail Ujian - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Detail Ujian: {{ $exam->name }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                {{ $exam->subject->name ?? 'N/A' }} - 
                                {{ $exam->schoolClass->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('guru.exams.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                            <a href="{{ route('guru.exams.edit', $exam) }}"
                               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Exam Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Basic Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Informasi Ujian
                        </h2>
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Ujian</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->name }}</dd>
                            </div>
                            @if($exam->description)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->description }}</dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mata Pelajaran</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->subject->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelas</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->schoolClass->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Publikasi</dt>
                                <dd class="mt-1">
                                    @if($exam->publish)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Diterbitkan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>Draft
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Schedule & Score Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Jadwal & Penilaian
                        </h2>
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Ujian</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $exam->exam_date ? $exam->exam_date->format('d F Y') : 'N/A' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Waktu</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if($exam->start_time && $exam->end_time)
                                        {{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($exam->end_time)->format('H:i') }}
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Durasi</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @php
                                        $duration = 'N/A';
                                        if($exam->start_time && $exam->end_time) {
                                            $start = \Carbon\Carbon::parse($exam->start_time);
                                            $end = \Carbon\Carbon::parse($exam->end_time);
                                            $duration = $end->diffInMinutes($start) . ' menit';
                                        }
                                    @endphp
                                    {{ $duration }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Skor Maksimal</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $exam->total_score }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Peserta</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $grades->count() }} siswa</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Grades Table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700">
                    <div class="px-6 py-4 border-b dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Daftar Nilai
                        </h2>
                    </div>
                    
                    @if($grades->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            NIS
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nama Siswa
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Skor
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Grade
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Catatan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($grades as $grade)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $grade->student->nis ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $grade->student->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $grade->score ?? 0 }} / {{ $exam->total_score }}
                                            </div>
                                            @php
                                                $percentage = $exam->total_score > 0 ? ($grade->score / $exam->total_score) * 100 : 0;
                                            @endphp
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($grade->grade_letter)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    @if($grade->grade_letter == 'A') bg-green-100 text-green-800
                                                    @elseif($grade->grade_letter == 'B') bg-blue-100 text-blue-800
                                                    @elseif($grade->grade_letter == 'C') bg-yellow-100 text-yellow-800
                                                    @elseif($grade->grade_letter == 'D') bg-orange-100 text-orange-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ $grade->grade_letter }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500 dark:text-gray-300 max-w-xs truncate">
                                                {{ $grade->notes ?? '-' }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Statistics -->
                        <div class="px-6 py-4 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                @php
                                    $totalStudents = $grades->count();
                                    $averageScore = $totalStudents > 0 ? $grades->avg('score') : 0;
                                    $maxScore = $grades->max('score') ?? 0;
                                    $minScore = $grades->min('score') ?? 0;
                                @endphp
                                <div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalStudents }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Total Siswa</div>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($averageScore, 1) }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Rata-rata</div>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $maxScore }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Tertinggi</div>
                                </div>
                                <div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $minScore }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Terendah</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-clipboard-list text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada nilai</h3>
                            <p class="text-gray-500 dark:text-gray-400">Belum ada siswa yang dinilai untuk ujian ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
