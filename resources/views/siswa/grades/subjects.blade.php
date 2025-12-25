@extends('layouts.app')

@section('title', 'Nilai per Mata Pelajaran')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Nilai per Mata Pelajaran</h1>
                        <p class="mt-1 text-sm text-gray-600">Klik mata pelajaran untuk melihat detail nilai</p>
                    </div>
                    <a href="{{ route('siswa.grades.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Lihat Semua Nilai
                    </a>
                </div>



                @if(empty($subjectData) || count($subjectData) == 0)
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 4H7m10-12V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v4H5l7 7 7-7h-3z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada nilai</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada nilai yang tersedia.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($subjectData as $data)
                        <a href="{{ route('siswa.grades.subject', $data['subject']->id) }}" 
                           class="block bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-blue-300 transition-all duration-200">
                            <div class="p-6">
                                <!-- Subject Name -->
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">
                                        {{ $data['subject']->name }}
                                    </h3>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>

                                <!-- Statistics -->
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Rata-rata</span>
                                        <span class="text-lg font-bold text-gray-900">{{ $data['average_score'] }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Jumlah Ujian</span>
                                        <span class="text-sm font-medium text-gray-900">{{ $data['total_exams'] }}</span>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Nilai Tertinggi</span>
                                        <span class="text-sm font-medium text-green-600">{{ $data['max_score'] }}</span>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Nilai Terendah</span>
                                        <span class="text-sm font-medium text-red-600">{{ $data['min_score'] }}</span>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Status</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($data['status_color'] === 'green') bg-green-100 text-green-800
                                            @elseif($data['status_color'] === 'yellow') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $data['status'] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mt-4">
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>Progress</span>
                                        <span>{{ $data['average_score'] }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full 
                                            @if($data['average_score'] >= 85) bg-green-500
                                            @elseif($data['average_score'] >= 70) bg-yellow-500
                                            @else bg-red-500 @endif" 
                                            style="width: {{ $data['average_score'] }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
