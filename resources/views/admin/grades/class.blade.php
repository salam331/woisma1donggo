@extends('layouts.app')

@section('title', 'Mata Pelajaran - ' . $schoolClass->name)

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Mata Pelajaran Kelas {{ $schoolClass->name }}</h3>
                            <nav class="text-sm text-gray-500">
                                <a href="{{ route('admin.grades.index') }}" class="hover:text-blue-600">Nilai Siswa</a> >
                                <span>{{ $schoolClass->name }}</span>
                            </nav>
                        </div>
                        <a href="{{ route('admin.grades.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>

                    {{-- Session alerts removed - now using toast notifications --}}

                    @forelse($subjects as $subject)
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
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
