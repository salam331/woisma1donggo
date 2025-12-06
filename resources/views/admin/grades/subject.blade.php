@extends('layouts.app')

@section('title', 'Ujian - ' . $subject->name . ' - ' . $schoolClass->name)

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Ujian {{ $subject->name }} - Kelas {{ $schoolClass->name }}</h3>
                            <nav class="text-sm text-gray-500">
                                <a href="{{ route('admin.grades.index') }}" class="hover:text-blue-600">Nilai Siswa</a> >
                                <a href="{{ route('admin.grades.class', $schoolClass->id) }}" class="hover:text-blue-600">{{ $schoolClass->name }}</a> >
                                <span>{{ $subject->name }}</span>
                            </nav>
                        </div>
                        <a href="{{ route('admin.grades.class', $schoolClass->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse($exams as $exam)
                        <div class="mb-4">
                            <div class="bg-blue-100 hover:bg-blue-200 p-4 rounded-lg cursor-pointer">
                                <a href="{{ route('admin.grades.exam', [$schoolClass->id, $subject->id, $exam->id]) }}" class="block">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $exam->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $exam->description ?? 'Tidak ada deskripsi' }}</p>
                                    <p class="text-xs text-gray-500">Tanggal: {{ $exam->exam_date ? \Carbon\Carbon::parse($exam->exam_date)->format('d M Y') : 'Tidak ditentukan' }}</p>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">Tidak ada ujian untuk mata pelajaran ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
