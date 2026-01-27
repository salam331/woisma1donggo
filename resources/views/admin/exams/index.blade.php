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

                    {{-- Session alerts removed - now using toast notifications --}}

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
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                            <div class="flex items-center justify-center gap-x-4">

                                                    {{-- Tombol Lihat (Biru terang) --}}
                                                    <a href="{{ route('admin.exams.show', $exam) }}"
                                                        class="p-2 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 hover:text-blue-900 transition-colors duration-200 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    </a>

                                                    {{-- Tombol Edit (Kuning terang) --}}
                                                    <a href="{{ route('admin.exams.edit', $exam) }}"
                                                        class="p-2 rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 transition-colors duration-200 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>
                                                    </a>

                                                    {{-- Tombol Hapus (Merah terang) --}}
                                                    <form method="POST" action="{{ route('admin.exams.destroy', $exam) }}" class="inline"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus ujian ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-2 rounded-full bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-900 transition-colors duration-200 shadow-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                </div>


                                            <!-- MOBILE -->
                                            {{-- <div class="mobile-actions sm:hidden">
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
                                            </div> --}}

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