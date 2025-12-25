@extends('layouts.app')

@section('title', isset($subject) ? 'Nilai ' . $subject->name : 'Nilai')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        @if(isset($subject))
                            <h1 class="text-2xl font-bold text-gray-900">Nilai {{ $subject->name }}</h1>
                            <p class="mt-1 text-sm text-gray-600">Detail nilai untuk mata pelajaran {{ $subject->name }}</p>
                        @else
                            <h1 class="text-2xl font-bold text-gray-900">Nilai</h1>
                            <p class="mt-1 text-sm text-gray-600">Semua nilai yang diterima</p>
                        @endif
                    </div>
                    <a href="{{ route('siswa.grades.subjects') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Lihat per Mata Pelajaran
                    </a>
                </div>

                <!-- Statistics Section (only show when viewing specific subject) -->
                @if(isset($subject) && isset($totalExams))
                <div class="mb-6 bg-gray-50 rounded-lg p-4">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Statistik Nilai</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $totalExams }}</div>
                            <div class="text-sm text-gray-600">Jumlah Ujian</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ round($averageScore, 1) }}</div>
                            <div class="text-sm text-gray-600">Rata-rata</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $maxScore }}</div>
                            <div class="text-sm text-gray-600">Nilai Tertinggi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">{{ $minScore }}</div>
                            <div class="text-sm text-gray-600">Nilai Terendah</div>
                        </div>
                    </div>
                </div>
                @endif

                @if($grades->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 4H7m10-12V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v4H5l7 7 7-7h-3z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada nilai</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if(isset($subject))
                                Belum ada nilai untuk mata pelajaran {{ $subject->name }}.
                            @else
                                Belum ada nilai yang tersedia.
                            @endif
                        </p>
                    </div>
                @else
                    <!-- Desktop Table View -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @if(!isset($subject))
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                                        @endif
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ujian</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($grades as $grade)
                                    <tr class="hover:bg-gray-50">
                                        @if(!isset($subject))
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <a href="{{ route('siswa.grades.subject', $grade->subject->id) }}" class="text-blue-600 hover:text-blue-800">
                                                {{ $grade->subject->name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $grade->exam->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($grade->score >= 85) bg-green-100 text-green-800
                                                @elseif($grade->score >= 70) bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $grade->score }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($grade->created_at)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @php
                                                $percentage = $grade->exam && $grade->exam->total_score > 0 
                                                    ? round(($grade->score / $grade->exam->total_score) * 100, 1) 
                                                    : 0;
                                            @endphp
                                            {{ $percentage }}%
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden space-y-4">
                        @foreach($grades as $grade)
                        <div class="bg-white rounded-lg shadow-sm border p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    @if(!isset($subject))
                                    <a href="{{ route('siswa.grades.subject', $grade->subject->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                        {{ $grade->subject->name ?? 'N/A' }}
                                    </a>
                                    @endif
                                    <p class="text-xs text-gray-500">{{ $grade->exam->name ?? 'N/A' }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($grade->score >= 85) bg-green-100 text-green-800
                                        @elseif($grade->score >= 70) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $grade->score }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>{{ \Carbon\Carbon::parse($grade->created_at)->format('d/m/Y') }}</span>
                                <span>
                                    @php
                                        $percentage = $grade->exam && $grade->exam->total_score > 0 
                                            ? round(($grade->score / $grade->exam->total_score) * 100, 1) 
                                            : 0;
                                    @endphp
                                    {{ $percentage }}%
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
