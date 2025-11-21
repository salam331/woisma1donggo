<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Materi: {{ $material->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.materials.edit', $material) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit Materi
                </a>
                <a href="{{ route('admin.materials.download', $material) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Download File
                </a>
                <a href="{{ route('admin.materials.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Material Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Materi</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16">
                                        @if(str_contains($material->file_type, 'image'))
                                            <img class="h-16 w-16 rounded-full object-cover" src="{{ asset('storage/' . $material->file_path) }}" alt="">
                                        @elseif(str_contains($material->file_type, 'pdf'))
                                            <div class="h-16 w-16 bg-red-100 rounded-full flex items-center justify-center">
                                                <span class="text-2xl font-bold text-red-600">PDF</span>
                                            </div>
                                        @elseif(str_contains($material->file_type, 'video'))
                                            <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-2xl font-bold text-blue-600">VID</span>
                                            </div>
                                        @else
                                            <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center">
                                                <span class="text-2xl font-bold text-gray-600">DOC</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-2xl font-medium text-gray-900">{{ $material->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $material->subject->name ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Judul Materi</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $material->title }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Mata Pelajaran</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $material->subject->name ?? '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Guru Pengajar</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $material->teacher->name ?? '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tipe File</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $material->file_type }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Ukuran File</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ number_format(Storage::disk('public')->size($material->file_path) / 1024, 1) }} KB</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $material->created_at->format('d F Y H:i') }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                @if($material->description)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $material->description }}</dd>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- File Preview -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Preview File</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                @if(str_contains($material->file_type, 'image'))
                                    <img src="{{ asset('storage/' . $material->file_path) }}" alt="{{ $material->title }}" class="w-full h-auto rounded-lg">
                                @elseif(str_contains($material->file_type, 'pdf'))
                                    <div class="text-center">
                                        <div class="h-32 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                                            <span class="text-4xl font-bold text-red-600">PDF</span>
                                        </div>
                                        <p class="text-gray-600">File PDF tidak dapat dipreview di browser</p>
                                        <a href="{{ route('admin.materials.download', $material) }}" class="inline-block mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Download untuk Melihat
                                        </a>
                                    </div>
                                @elseif(str_contains($material->file_type, 'video'))
                                    <video controls class="w-full rounded-lg">
                                        <source src="{{ asset('storage/' . $material->file_path) }}" type="{{ $material->file_type }}">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                @else
                                    <div class="text-center">
                                        <div class="h-32 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                                            <span class="text-4xl font-bold text-gray-600">DOC</span>
                                        </div>
                                        <p class="text-gray-600">File dokumen tidak dapat dipreview di browser</p>
                                        <a href="{{ route('admin.materials.download', $material) }}" class="inline-block mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Download untuk Melihat
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Aksi Cepat</h4>
                                <div class="space-y-2">
                                    <a href="{{ route('admin.materials.edit', $material) }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Edit Informasi Materi
                                    </a>
                                    <a href="{{ route('admin.materials.download', $material) }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Download File Materi
                                    </a>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-red-700 bg-white border border-red-300 rounded-md hover:bg-red-50">
                                        Hapus Materi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
