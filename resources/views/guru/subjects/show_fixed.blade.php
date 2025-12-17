@extends('layouts.app')

@section('title', 'Detail Mata Pelajaran - ' . $subject->name . ' - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b dark:border-gray-700">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('guru.subjects.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Mata Pelajaran</h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-6xl mx-auto">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Subject Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Subject Details -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                    {{ $subject->name }}
                                </h2>
                                <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $subject->created_at->format('d F Y, H:i') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-code mr-1"></i>
                                        {{ $subject->code }}
                                    </span>
                                </div>
                            </div>

                            @if($subject->description)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        <i class="fas fa-align-left mr-2"></i>Deskripsi
                                    </h3>
                                    <div class="prose dark:prose-invert max-w-none">
                                        {!! nl2br(e($subject->description)) !!}
                                    </div>
                                </div>
                            @endif

                            <!-- Quick Stats -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg border border-blue-200 dark:border-blue-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-blue-500 text-xl mr-3"></i>
                                        <div>
                                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Jadwal</p>
                                            <p class="text-2xl font-bold text-blue-800 dark:text-blue-200">{{ $subject->schedules->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg border border-green-200 dark:border-green-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-users text-green-500 text-xl mr-3"></i>
                                        <div>
                                            <p class="text-sm font-medium text-green-600 dark:text-green-400">Total Kelas</p>
                                            <p class="text-2xl font-bold text-green-800 dark:text-green-200">{{ $subject->schedules->pluck('class')->unique()->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg border border-purple-200 dark:border-purple-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-alt text-purple-500 text-xl mr-3"></i>
                                        <div>
                                            <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Total Materi</p>
                                            <p class="text-2xl font-bold text-purple-800 dark:text-purple-200">{{ $subject->materials()->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Information -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    <i class="fas fa-calendar-alt mr-2"></i>Jadwal Mengajar
                                </h3>
                            </div>

                            @if($subject->schedules->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Kelas
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Hari
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Waktu
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Ruang
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                            @foreach($subject->schedules as $schedule)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $schedule->class->name ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $schedule->class->grade_level }} {{ $schedule->class->major ? '(' . $schedule->class->major . ')' : '' }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                        {{ $schedule->day }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $schedule->room ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('guru.schedules.show', $schedule) }}"
                                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                        <i class="fas fa-eye mr-1"></i>Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-500 dark:text-gray-400">Belum ada jadwal untuk mata pelajaran ini</p>
                                    <a href="{{ route('guru.schedules.create') }}?subject_id={{ $subject->id }}"
                                       class="inline-flex items-center px-4 py-2 mt-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition duration-200">
                                        <i class="fas fa-plus mr-2"></i>Tambah Jadwal Pertama
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Materials Information -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    <i class="fas fa-file-alt mr-2"></i>Materi Pembelajaran
                                </h3>
                                <a href="{{ route('guru.materials.create') }}?subject_id={{ $subject->id }}"
                                   class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm font-medium transition duration-200">
                                    <i class="fas fa-plus mr-1"></i>Tambah Materi
                                </a>
                            </div>

                            @if($subject->materials()->count() > 0)
                                <div class="space-y-4">
                                    @foreach($subject->materials()->take(5)->get() as $material)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                @if($material->mime_type && str_starts_with($material->mime_type, 'image/'))
                                                    <img src="{{ asset('storage/' . $material->file_path) }}" 
                                                         alt="{{ $material->file_name }}"
                                                         class="w-12 h-12 object-cover rounded">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                        <i class="fas fa-file text-gray-500 dark:text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $material->title }}
                                                </h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $material->class->name ?? 'N/A' }} • 
                                                    {{ $material->created_at->format('d F Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $material->is_public ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' }}">
                                                <i class="fas fa-{{ $material->is_public ? 'eye' : 'lock' }} mr-1"></i>
                                                {{ $material->is_public ? 'Publik' : 'Private' }}
                                            </span>
                                            <a href="{{ route('guru.materials.show', $material) }}"
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach

                                    @if($subject->materials()->count() > 5)
                                        <div class="text-center pt-4">
                                            <a href="{{ route('guru.materials.index') }}?subject_id={{ $subject->id }}"
                                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                                Lihat semua {{ $subject->materials()->count() }} materi →
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-file-times text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-500 dark:text-gray-400">Belum ada materi untuk mata pelajaran ini</p>
                                    <a href="{{ route('guru.materials.create') }}?subject_id={{ $subject->id }}"
                                       class="inline-flex items-center px-4 py-2 mt-4 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition duration-200">
                                        <i class="fas fa-plus mr-2"></i>Tambah Materi Pertama
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sidebar Information -->
                    <div class="space-y-6">
                        <!-- Quick Actions -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-tools mr-2"></i>Aksi Cepat
                            </h3>
                            <div class="space-y-3">
                                <a href="{{ route('guru.materials.create') }}?subject_id={{ $subject->id }}"
                                   class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                                    <i class="fas fa-file-plus mr-2"></i>Tambah Materi
                                </a>
                                
                                <a href="{{ route('guru.schedules.create') }}?subject_id={{ $subject->id }}"
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                                    <i class="fas fa-calendar-plus mr-2"></i>Tambah Jadwal
                                </a>
                                
                                <a href="{{ route('guru.attendances.create') }}?subject_id={{ $subject->id }}"
                                   class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                                    <i class="fas fa-clipboard-check mr-2"></i>Input Absensi
                                </a>
                            </div>
                        </div>

                        <!-- Class Information -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-users mr-2"></i>Kelas yang Diajar
                            </h3>
                            @if($subject->schedules->pluck('class')->unique()->count() > 0)
                                <div class="space-y-3">
                                    @foreach($subject->schedules->pluck('class')->unique() as $class)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $class->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $class->grade_level }} {{ $class->major ? '(' . $class->major . ')' : '' }}
                                            </p>
                                        </div>
                                        <a href="{{ route('guru.schedules.show', $subject->schedules->where('class_id', $class->id)->first()) }}"
                                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada kelas yang ditetapkan</p>
                            @endif
                        </div>

                        <!-- Subject Statistics -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-chart-bar mr-2"></i>Statistik
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">Dibuat:</span>
                                    <span class="text-gray-900 dark:text-gray-100 text-sm">{{ $subject->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">Diperbarui:</span>
                                    <span class="text-gray-900 dark:text-gray-100 text-sm">{{ $subject->updated_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 dark:text-gray-400">Kode:</span>
                                    <span class="text-gray-900 dark:text-gray-100 text-sm font-mono">{{ $subject->code }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
