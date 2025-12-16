@extends('layouts.app')

@section('title', 'Detail Kelas - ' . $class->name)

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <a href="{{ route('guru.classes.index') }}"
                                    class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Kembali ke Daftar Kelas
                                </a>
                                <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $class->name }}</h1>
                                <p class="text-gray-600 dark:text-gray-400">Detail kelas dan informasi lengkap</p>
                            </div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                Kelas {{ $class->grade_level }}
                            </span>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Class Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <div class="lg:col-span-2">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Kelas</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                            Kelas</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $class->name }}</p>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $class->grade_level }}
                                        </p>
                                    </div>
                                    @if($class->description)
                                        <div class="mt-4">
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $class->description }}
                                            </p>
                                        </div>
                                    @endif
                                    @if($class->major)
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jurusan</label>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $class->major }}</p>
                                        </div>
                                    @endif
                                    {{-- <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun
                                            Ajaran</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $class->academic_year }}
                                        </p>
                                    </div> --}}
                                    {{-- <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kapasitas</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $class->capacity }}
                                            siswa</p>
                                    </div> --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah
                                            Siswa</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $class->students->count() }} siswa</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Aksi Cepat</h3>
                                <div class="space-y-3">
                                    <a href="{{ route('guru.classes.students', $class) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                            </path>
                                        </svg>
                                        Kelola Siswa
                                    </a>
                                    <a href="{{ route('guru.attendances.index-by-class', $class) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                            </path>
                                        </svg>
                                        Kehadiran
                                    </a>

                                    <a href="{{ route('guru.attendances.index-by-class', $class) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Jadwal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Students List -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Daftar Siswa
                                ({{ $class->students->count() }})</h3>
                            <a href="{{ route('guru.classes.students', $class) }}"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                Lihat Semua →
                            </a>
                        </div>

                        @if($class->students->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                NIS</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Nama</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Email</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach($class->students->take(5) as $student)
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $student->nis }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $student->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $student->email }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    <a href="{{ route('guru.attendances.student-history', [$student, 1]) }}"
                                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                                        Kehadiran
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($class->students->count() > 5)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('guru.classes.students', $class) }}"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        Lihat Semua Siswa ({{ $class->students->count() }})
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada siswa</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada siswa yang terdaftar di kelas ini.
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Schedules -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Jadwal Mata Pelajaran
                                ({{ $class->schedules->count() - 1 }})</h3>

                            <a href="{{ route('guru.attendances.index-by-class', $class) }}"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                Lihat Semua →
                            </a>
                        </div>


                        @if(isset($class->teacher_schedules) && $class->teacher_schedules->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($class->teacher_schedules->take(6) as $schedule)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $schedule->subject->name }}</h4>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                {{ $schedule->day }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            <p>{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                                            <p>Ruang: {{ $schedule->class->name }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($class->teacher_schedules->count() > 6)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('guru.attendances.index-by-class', $class) }}"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        Lihat Semua Jadwal ({{ $class->teacher_schedules->count() }})
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada jadwal</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada jadwal mata pelajaran yang Anda ajar untuk kelas ini.
                                </p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection