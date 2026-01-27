@extends('layouts.app')

@section('title', 'Manajemen Nilai Siswa')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Nilai Siswa</h3>
                        <a href="{{ route('admin.grades.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Nilai
                        </a>
                    </div>

                    {{-- Session alerts removed - now using toast notifications --}}

                    @forelse($grades as $classId => $classGrades)
                        <div class="mb-8">
                            <div class="bg-red-100 hover:bg-red-200 p-4 rounded-lg cursor-pointer">
                                <a href="{{ route('admin.grades.class', $classId) }}" class="block">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $classNames[$classId] ?? 'Kelas Tidak Diketahui' }}</h4>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">Tidak ada data nilai.</p>
                        </div>
                    @endforelse
                    {{-- @forelse($subjects as $subject)
                        <div class="mb-4">
                            <div class="bg-green-100 hover:bg-green-200 p-4 rounded-lg cursor-pointer">
                                <a href="{{ route('admin.grades.subject', [$schoolClass->id, $subject->id]) }}" class="block">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $subject->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $subject->description ?? 'Tidak ada deskripsi' }}</p>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">Tidak ada mata pelajaran untuk kelas ini.</p>
                        </div>
                    @endforelse --}}
                </div>
            </div>
        </div>
    </div>
@endsection
