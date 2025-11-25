@extends('layouts.app')

@section('title', 'Detail Siswa: ' . $student->name)

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">

            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                    Detail Siswa: {{ $student->name }}
                </h2>

                <div class="flex space-x-2">
                    <a href="{{ route('admin.students.edit', $student) }}"
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Edit Siswa
                    </a>

                    <a href="{{ route('admin.students.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Bagian Informasi Siswa -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">
                        Informasi Siswa
                    </h3>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            @if($student->photo)
                                <img class="h-20 w-20 rounded-full object-cover"
                                     src="{{ asset('storage/' . $student->photo) }}"
                                     alt="{{ $student->name }}">
                            @else
                                <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-xl font-medium text-gray-700">
                                        {{ substr($student->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif

                            <div class="ml-4">
                                <div class="text-xl font-medium text-gray-900 dark:text-gray-100">
                                    {{ $student->name }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $student->email }}
                                </div>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">NIS</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $student->nis }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $student->email }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Telepon</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $student->phone ?? '-' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $student->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $student->birth_date
                                            ? \Carbon\Carbon::parse($student->birth_date)->format('d F Y')
                                            : '-' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $student->class->name ?? '-' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Orang Tua</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $student->parent->name ?? '-' }}
                                    </dd>
                                </div>

                            </dl>
                        </div>

                        @if($student->address)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $student->address }}
                                </dd>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-4">
                        Informasi Tambahan
                    </h3>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <p><strong>ID Siswa:</strong> {{ $student->id }}</p>
                            <p><strong>Dibuat:</strong> {{ $student->created_at->format('d F Y H:i') }}</p>
                            <p><strong>Terakhir Update:</strong> {{ $student->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Aksi Cepat -->
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-200 mb-3">
                            Aksi Cepat
                        </h4>

                        <div class="space-y-2">
                            <a href="{{ route('admin.students.edit', $student) }}"
                               class="block w-full px-4 py-2 text-sm bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Edit Informasi Siswa
                            </a>

                            <button class="block w-full px-4 py-2 text-sm bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Lihat Nilai Raport
                            </button>

                            <button class="block w-full px-4 py-2 text-sm bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Lihat Absensi
                            </button>

                            <button class="block w-full px-4 py-2 text-sm bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Lihat Tagihan
                            </button>

                            <button class="block w-full px-4 py-2 text-sm text-red-700 bg-white dark:bg-gray-800 border border-red-300 rounded-md hover:bg-red-50 dark:hover:bg-red-900">
                                Nonaktifkan Akun
                            </button>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
