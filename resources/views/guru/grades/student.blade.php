@extends('layouts.app')

@section('title', 'Detail Nilai ' . $student->name . ' - ' . $subject->name . ' - Kelas ' . $class->name . ' - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('guru.grades.exam', [$class->id, $subject->id, $exam->id]) }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Nilai {{ $exam->title }}
                    </a>
                </div>

                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Detail Nilai {{ $student->name }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ $subject->name }} - Kelas {{ $class->name }} | {{ $exam->title }} ({{ $exam->exam_date->format('d M Y') }})
                    </p>
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

                <!-- Student Info & Grade -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Siswa & Nilai</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student Information -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Informasi Siswa</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</dt>
                                        <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $student->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIS</dt>
                                        <dd class="text-gray-900 dark:text-gray-300">{{ $student->student_id ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelas</dt>
                                        <dd class="text-gray-900 dark:text-gray-300">{{ $class->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mata Pelajaran</dt>
                                        <dd class="text-gray-900 dark:text-gray-300">{{ $subject->name }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Grade Information -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Informasi Nilai</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ujian</dt>
                                        <dd class="text-lg font-semibold text-gray-900 dark:text-white">{{ $exam->title }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Ujian</dt>
                                        <dd class="text-gray-900 dark:text-gray-300">{{ $exam->exam_date->format('d M Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nilai</dt>
                                        @if($grade)
                                            <dd class="text-2xl font-bold 
                                                {{ $grade->score >= 90 ? 'text-green-600' : 
                                                   ($grade->score >= 80 ? 'text-blue-600' : 
                                                   ($grade->score >= 70 ? 'text-yellow-600' : 
                                                   ($grade->score >= 60 ? 'text-orange-600' : 'text-red-600'))) }}">
                                                {{ $grade->score }}
                                            </dd>
                                        @else
                                            <dd class="text-gray-400">Belum ada nilai</dd>
                                        @endif
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Grade</dt>
                                        @if($grade)
                                            <dd class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                                {{ $grade->score >= 90 ? 'bg-green-100 text-green-800' : 
                                                   ($grade->score >= 80 ? 'bg-blue-100 text-blue-800' : 
                                                   ($grade->score >= 70 ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($grade->score >= 60 ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'))) }}">
                                                {{ getLetterGrade($grade->score) }}
                                            </dd>
                                        @else
                                            <dd class="text-gray-400">-</dd>
                                        @endif
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex space-x-4">
                    <a href="{{ route('guru.grades.edit-exam', [$class->id, $subject->id, $exam->id]) }}"
                       class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Nilai
                    </a>
                    <a href="{{ route('guru.grades.exam', [$class->id, $subject->id, $exam->id]) }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                        <i class="fas fa-list mr-2"></i>
                        Lihat Semua Nilai
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

@php
function getLetterGrade($score) {
    if ($score >= 90) return 'A';
    if ($score >= 80) return 'B';
    if ($score >= 70) return 'C';
    if ($score >= 60) return 'D';
    return 'E';
}
@endphp
@endsection

