@extends('layouts.app')

@section('title', 'Detail Kelas: ' . $class->name)

@section('content')

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                    Detail Kelas: {{ $class->name }}
                </h2>

                <div class="flex space-x-2">
                    <a href="{{ route('admin.classes.edit', $class) }}"
                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Edit Kelas
                    </a>
                    <a href="{{ route('admin.classes.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Informasi Kelas -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Kelas</h3>

                    <div class="space-y-4">

                        <!-- Icon + Nama -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-blue-600">{{ substr($class->name, 0, 2) }}</span>
                            </div>

                            <div class="ml-4">
                                <div class="text-2xl font-medium text-gray-900 dark:text-gray-100">{{ $class->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $class->grade_level }}</div>
                            </div>
                        </div>

                        <!-- Detail -->
                        <div class="border-t pt-4 dark:border-gray-700">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Kelas</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $class->name }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tingkat</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $class->grade_level }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Wali Kelas</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $class->teacher ? $class->teacher->name : '-' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Siswa</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $class->students->count() }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        @if($class->description)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $class->description }}</dd>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Daftar Siswa -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Daftar Siswa ({{ $class->students->count() }})
                    </h3>

                    @if($class->students->count() > 0)
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @foreach($class->students as $student)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-center justify-between">

                                        <div class="flex items-center">
                                            @if($student->photo)
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <span
                                                        class="text-sm font-medium text-gray-700">{{ substr($student->name, 0, 1) }}</span>
                                                </div>
                                            @endif

                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $student->name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">NIS: {{ $student->nis }}</div>
                                            </div>
                                        </div>

                                        <a href="{{ route('admin.students.show', $student) }}"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-200 text-sm">
                                            Lihat Detail
                                        </a>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                            <p class="text-gray-500 dark:text-gray-300">
                                Belum ada siswa yang terdaftar di kelas ini.
                            </p>
                        </div>
                    @endif

                    <!-- Informasi Tambahan -->
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Informasi Tambahan</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                                <p><strong>ID Kelas:</strong> {{ $class->id }}</p>
                                <p><strong>Dibuat:</strong> {{ $class->created_at->format('d F Y H:i') }}</p>
                                <p><strong>Terakhir Update:</strong> {{ $class->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Aksi Cepat</h4>
                        <div class="space-y-2">

                            <a href="{{ route('admin.classes.edit', $class) }}"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Edit Informasi Kelas
                            </a>

                            <button
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Lihat Jadwal Pelajaran
                            </button>

                            <button
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Lihat Absensi Kelas
                            </button>

                            <button
                                class="block w-full text-left px-4 py-2 text-sm text-red-700 bg-white dark:bg-gray-800 border border-red-300 rounded-md hover:bg-red-50 dark:hover:bg-red-900">
                                Hapus Kelas
                            </button>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection