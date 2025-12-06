@extends('layouts.app')

@section('title', 'Manajemen Ujian')

@section('content')

    <div>
        <div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Ujian</h3>
                        <a href="{{ route('admin.exams.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Ujian
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Judul
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Mata Pelajaran
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kelas
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Guru
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Ujian
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu Ujian
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">

                                @forelse($exams as $exam)
                                    <tr class="hover:bg-gray-50">
                                        <td data-label="Status" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($exam->publish)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Published
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Draft
                                                </span>
                                            @endif
                                        </td>

                                        <td data-label="Judul"
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $exam->name }}
                                        </td>

                                        <td data-label="Mata Pelajaran"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $exam->subject->name ?? '-' }}
                                        </td>

                                        <td data-label="Kelas" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $exam->schoolClass->name ?? '-' }}
                                        </td>

                                        <td data-label="Guru" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $exam->teacher->name ?? '-' }}
                                        </td>

                                        <td data-label="Tanggal" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $exam->exam_date->format('d/m/Y') }}
                                        </td>

                                        <td data-label="Waktu" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $exam->start_time }} - {{ $exam->end_time }}
                                        </td>

                                        <td data-label="Aksi" class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                            <!-- DESKTOP -->
                                            <div class="hidden sm:flex justify-end space-x-2">
                                                <a href="{{ route('admin.exams.show', $exam) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-2">Lihat</a>
                                                <a href="{{ route('admin.exams.edit', $exam) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                                <form method="POST" action="{{ route('admin.exams.destroy', $exam) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus ujian ini?')">Hapus</button>
                                                </form>
                                            </div>

                                            <!-- MOBILE -->
                                            <div class="mobile-actions sm:hidden">
                                                <a href="{{ route('admin.exams.show', $exam) }}"
                                                    class="px-3 py-1 text-xs rounded bg-blue-500 text-white">Lihat</a>
                                                <a href="{{ route('admin.exams.edit', $exam) }}"
                                                    class="px-3 py-1 text-xs rounded bg-indigo-500 text-white">Edit</a>
                                                <form method="POST" action="{{ route('admin.exams.destroy', $exam) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1 text-xs rounded bg-red-500 text-white"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus ujian ini?')">Hapus</button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Tidak ada data ujian.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $exams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection