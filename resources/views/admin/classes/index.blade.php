@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('content')

   

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Search and Filter -->
            <form method="GET" action="{{ route('admin.classes.index') }}"
                class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">

                {{-- SEARCH --}}
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari Nama Kelas atau Wali..."
                    {{-- oninput="this.form.submit()" --}}
                    class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900
                        rounded-lg px-4 py-2 w-full sm:w-64"
                >

                <div class="flex space-x-2">

                    {{-- FILTER TINGKAT --}}
                    <select
                        name="grade_level"
                        onchange="this.form.submit()"
                        class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900
                            rounded-lg px-4 py-2"
                    >
                        <option value="">Semua Tingkat</option>
                        @foreach ($gradeLevels as $level)
                            <option value="{{ $level }}"
                                {{ request('grade_level') == $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                        @endforeach
                    </select>

                    {{-- FILTER WALI KELAS --}}
                    <select
                        name="teacher"
                        onchange="this.form.submit()"
                        class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900
                            rounded-lg px-4 py-2"
                    >
                        <option value="">Semua Wali Kelas</option>
                        <option value="with" {{ request('teacher') === 'with' ? 'selected' : '' }}>
                            Ada Wali Kelas
                        </option>
                        <option value="without" {{ request('teacher') === 'without' ? 'selected' : '' }}>
                            Tanpa Wali Kelas
                        </option>
                    </select>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.classes.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Kelas
                        </a>
                    </div>

                </div>
            </form>

            <!-- Classes Table -->
            <div class="overflow-x-auto">
                <table class="table-responsive min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Kelas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tingkat
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Wali Kelas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah Siswa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($classes as $class)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100"
                                    data-label="Nama Kelas">
                                    {{ $class->name }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap" data-label="Tingkat">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                    text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $class->grade_level }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200"
                                    data-label="Wali Kelas">
                                    {{ $class->teacher ? $class->teacher->name : '-' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                                    data-label="Jumlah Siswa">
                                    {{ $class->students->count() }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                                    data-label="Deskripsi">
                                    {{ $class->description ?? '-' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                    data-label="Aksi">
                                    <div class="flex items-center justify-center gap-x-4">

                                        {{-- Tombol Lihat (Biru terang) --}}
                                        <a href="{{ route('admin.classes.show', $class) }}"
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
                                        <a href="{{ route('admin.classes.edit', $class) }}"
                                            class="p-2 rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 transition-colors duration-200 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>

                                        {{-- Tombol Hapus (Merah terang) --}}
                                        <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')"
                                                class="p-2 rounded-full bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-900 transition-colors duration-200 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>

                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data kelas ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <!-- Pagination -->
            @if($classes->hasPages())
                <div class="mt-6">
                    {{ $classes->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection