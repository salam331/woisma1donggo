@extends('layouts.app')

@section('title', 'Nilai Siswa - ' . $exam->name . ' - ' . $subject->name)

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Nilai Siswa - {{ $exam->name }}</h3>
                            <nav class="text-sm text-gray-500">
                                <a href="{{ route('admin.grades.index') }}" class="hover:text-blue-600">Nilai Siswa</a> >
                                <a href="{{ route('admin.grades.class', $schoolClass->id) }}" class="hover:text-blue-600">{{ $schoolClass->name }}</a> >
                                <a href="{{ route('admin.grades.subject', [$schoolClass->id, $subject->id]) }}" class="hover:text-blue-600">{{ $subject->name }}</a> >
                                <span>{{ $exam->name }}</span>
                            </nav>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.grades.edit-exam', [$schoolClass->id, $subject->id, $exam->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit Nilai
                            </a>
                            <a href="{{ route('admin.grades.subject', [$schoolClass->id, $subject->id]) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse($grades as $grade)
                        <div class="mb-4">
                            <div class="bg-purple-100 hover:bg-purple-200 p-4 rounded-lg cursor-pointer">
                                <a href="{{ route('admin.grades.student', [$schoolClass->id, $subject->id, $exam->id, $grade->student_id]) }}" class="block">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $grade->student->name }}</h4>
                                    <p class="text-sm text-gray-600">Nilai: {{ $grade->score }} ({{ $grade->grade_letter }})</p>
                                    <p class="text-xs text-gray-500">{{ $grade->notes ?? 'Tidak ada catatan' }}</p>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada nilai untuk ujian ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
