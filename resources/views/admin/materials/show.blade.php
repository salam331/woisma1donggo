@extends('layouts.app')

@section('title', 'Detail Materi Pembelajaran - Admin Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b dark:border-gray-700">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-book-open text-blue-600"></i>
                        Detail Materi Pembelajaran
                    </h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.materials.edit', $material->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.materials.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column: Material Details -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Material Info Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                            <!-- Header with File Type Icon -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 h-16 w-16">
                                        @if($material->mime_type && str_starts_with($material->mime_type, 'image/'))
                                            <img src="{{ asset('storage/' . $material->file_path) }}" alt="{{ $material->title }}" class="h-16 w-16 object-cover rounded-lg">
                                        @elseif($material->mime_type === 'application/pdf')
                                            <div class="h-16 w-16 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                                            </div>
                                        @elseif(str_contains($material->mime_type, 'video'))
                                            <div class="h-16 w-16 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-file-video text-blue-500 text-2xl"></i>
                                            </div>
                                        @elseif(str_contains($material->mime_type, 'word') || str_contains($material->mime_type, 'document'))
                                            <div class="h-16 w-16 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-file-word text-blue-500 text-2xl"></i>
                                            </div>
                                        @elseif(str_contains($material->mime_type, 'sheet') || str_contains($material->mime_type, 'excel'))
                                            <div class="h-16 w-16 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-file-excel text-green-500 text-2xl"></i>
                                            </div>
                                        @elseif(str_contains($material->mime_type, 'presentation') || str_contains($material->mime_type, 'powerpoint'))
                                            <div class="h-16 w-16 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-file-powerpoint text-orange-500 text-2xl"></i>
                                            </div>
                                        @else
                                            <div class="h-16 w-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-file text-gray-500 text-2xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $material->title }}</h2>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $material->is_public ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                <i class="fas {{ $material->is_public ? 'fa-eye' : 'fa-lock' }} mr-1"></i>
                                                {{ $material->is_public ? 'Publik' : 'Private' }}
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $material->subject->name ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($material->description)
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    <i class="fas fa-align-left mr-2 text-gray-400"></i>
                                    Deskripsi
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $material->description }}</p>
                            </div>
                            @endif

                            <!-- File Preview -->
                            <div class="border-t dark:border-gray-600 pt-6">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-4">
                                    <i class="fas fa-eye mr-2 text-gray-400"></i>
                                    Preview File
                                </h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    @if($material->mime_type && str_starts_with($material->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $material->file_path) }}" alt="{{ $material->title }}" class="w-full h-auto rounded-lg">
                                    @elseif($material->mime_type === 'application/pdf')
                                        <div class="text-center py-8">
                                            <div class="h-24 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mb-4 mx-auto w-24">
                                                <i class="fas fa-file-pdf text-red-500 text-4xl"></i>
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-300 mb-4">File PDF tidak dapat dipreview di browser</p>
                                            <a href="{{ route('admin.materials.download', $material->id) }}"
                                               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                                <i class="fas fa-download mr-2"></i>Download untuk Melihat
                                            </a>
                                        </div>
                                    @elseif(str_contains($material->mime_type, 'video'))
                                        <video controls class="w-full rounded-lg">
                                            <source src="{{ asset('storage/' . $material->file_path) }}" type="{{ $material->mime_type }}">
                                            Browser Anda tidak mendukung tag video.
                                        </video>
                                    @else
                                        <div class="text-center py-8">
                                            <div class="h-24 bg-gray-100 dark:bg-gray-600 rounded-lg flex items-center justify-center mb-4 mx-auto w-24">
                                                <i class="fas fa-file text-gray-500 text-4xl"></i>
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-300 mb-4">File tidak dapat dipreview di browser</p>
                                            <a href="{{ route('admin.materials.download', $material->id) }}"
                                               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                                <i class="fas fa-download mr-2"></i>Download untuk Melihat
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Actions & Statistics -->
                    <div class="space-y-6">
                        <!-- Quick Actions Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                                Aksi Cepat
                            </h3>
                            <div class="space-y-3">
                                <a href="{{ route('admin.materials.edit', $material->id) }}"
                                   class="flex items-center px-4 py-3 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300 rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition duration-200">
                                    <i class="fas fa-edit w-6"></i>
                                    <span class="font-medium">Edit Materi</span>
                                </a>
                                <a href="{{ route('admin.materials.download', $material->id) }}"
                                   class="flex items-center px-4 py-3 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 dark:hover:bg-green-800 transition duration-200">
                                    <i class="fas fa-download w-6"></i>
                                    <span class="font-medium">Download File</span>
                                </a>
                                <form method="POST" action="{{ route('admin.materials.destroy', $material->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full flex items-center px-4 py-3 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition duration-200">
                                        <i class="fas fa-trash w-6"></i>
                                        <span class="font-medium">Hapus Materi</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Statistics Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                                Informasi File
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-hdd mr-2 text-gray-400"></i>
                                        Ukuran
                                    </span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $material->file_size ? number_format($material->file_size / 1024, 2) . ' KB' : '-' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-file mr-2 text-gray-400"></i>
                                        Tipe File
                                    </span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $material->mime_type ?: '-' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                        Dibuat
                                    </span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $material->created_at->format('d F Y') }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                                        Diperbarui
                                    </span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $material->updated_at->format('d F Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Related Information Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                                Informasi Terkait
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 block">
                                        <i class="fas fa-book mr-2 text-gray-400"></i>
                                        Mata Pelajaran
                                    </span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $material->subject->name ?? '-' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 block">
                                        <i class="fas fa-user-graduate mr-2 text-gray-400"></i>
                                        Guru Pengajar
                                    </span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $material->teacher->name ?? '-' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 block">
                                        <i class="fas fa-users mr-2 text-gray-400"></i>
                                        Kelas
                                    </span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $material->class->name ?? '-' }}
                                    </span>
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

