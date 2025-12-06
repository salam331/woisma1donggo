@extends('layouts.app')

@section('title', 'Detail Ujian')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $exam->name }}</h3>
                        <div>
                            <a href="{{ route('admin.exams.edit', $exam) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.exams.destroy', $exam) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus ujian ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-4">Informasi Ujian</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->description ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Mata Pelajaran</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->subject->name ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->schoolClass->name ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Guru</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->teacher->name ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-4">Detail Ujian</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Ujian</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->exam_date->format('d/m/Y') }}</dd>
                                </div>
                                {{-- <div>
                                    <dt class="text-sm font-medium text-gray-500">Tipe Ujian</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->exam_type }}</dd>
                                </div> --}}
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Skor Total</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->total_score }}</dd>
                                </div>
                                {{-- <div>
                                    <dt class="text-sm font-medium text-gray-500">Tahun Akademik</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->academic_year }}</dd>
                                </div> --}}
                                {{-- status publish --}}
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($exam->publish)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Published
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Draft
                                                </span>
                                            @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    @if($exam->grades->count() > 0)
                        <div class="mt-8">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Nilai Siswa</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Siswa
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nilai Angka
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Grade Huruf
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Catatan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($exam->grades as $grade)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $grade->student->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $grade->score }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $grade->grade_letter }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $grade->notes ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('admin.exams.index') }}" class="text-indigo-600 hover:text-indigo-900">Kembali ke Daftar Ujian</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
