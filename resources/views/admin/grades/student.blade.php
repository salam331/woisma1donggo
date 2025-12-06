@extends('layouts.app')

@section('title', 'Detail Nilai - ' . $student->name . ' - ' . $exam->name)

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Detail Nilai {{ $student->name }}</h3>
                            <nav class="text-sm text-gray-500">
                                <a href="{{ route('admin.grades.index') }}" class="hover:text-blue-600">Nilai Siswa</a> >
                                <a href="{{ route('admin.grades.class', $schoolClass->id) }}" class="hover:text-blue-600">{{ $schoolClass->name }}</a> >
                                <a href="{{ route('admin.grades.subject', [$schoolClass->id, $subject->id]) }}" class="hover:text-blue-600">{{ $subject->name }}</a> >
                                <a href="{{ route('admin.grades.exam', [$schoolClass->id, $subject->id, $exam->id]) }}" class="hover:text-blue-600">{{ $exam->name }}</a> >
                                <span>{{ $student->name }}</span>
                            </nav>
                        </div>
                        <a href="{{ route('admin.grades.exam', [$schoolClass->id, $subject->id, $exam->id]) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($grade)
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="text-xl font-semibold mb-4">Informasi Nilai</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Siswa</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $grade->student->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kelas</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $schoolClass->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $grade->subject->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ujian</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $grade->exam->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nilai Angka</label>
                                    <p class="mt-1 text-sm text-gray-900 font-bold">{{ $grade->score }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Grade Huruf</label>
                                    <p class="mt-1 text-sm text-gray-900 font-bold">{{ $grade->grade_letter }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $grade->notes ?? 'Tidak ada catatan' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Nilai untuk siswa ini belum tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
