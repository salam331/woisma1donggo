<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Galeri: {{ $gallery->title }}
            </h2>
            <a href="{{ route('admin.galleries.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Judul</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $gallery->title }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Deskripsi</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $gallery->description ?? '-' }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Kategori</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $gallery->category ?? '-' }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Tanggal Event</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $gallery->event_date ? $gallery->event_date->format('d M Y') : '-' }}</p>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Gambar</h3>
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full max-w-sm h-auto rounded-lg shadow-sm">
                                </div>
                                @if($gallery->additional_images)
                                    <div class="mt-4">
                                        <h4 class="text-md font-medium text-gray-700 mb-2">Gambar Tambahan</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach($gallery->additional_images as $additional)
                                                <div class="border rounded-lg p-2">
                                                    <img src="{{ asset('storage/' . $additional['image_path']) }}" alt="{{ $additional['description'] ?? 'Additional Image' }}" class="w-full h-32 object-cover rounded">
                                                    @if($additional['description'])
                                                        <p class="text-sm text-gray-600 mt-1">{{ $additional['description'] }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Status</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $gallery->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $gallery->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Dibuat Pada</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $gallery->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end mt-6 space-x-2">
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus galeri ini?')">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
