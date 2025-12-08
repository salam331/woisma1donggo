@extends('layouts.app')

@section('title', 'Manajemen Materi Pelajaran')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Search and Filter -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <input type="text" placeholder="Cari galeri..." class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-64">
                        </div>
                        <div class="flex space-x-2">
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Status</option>
                                <option>Aktif</option>
                                <option>Tidak Aktif</option>
                            </select>
                        </div>
                        {{-- tambahkan tombol tambah galeri di sini --}}
                        <div>
                            <a href="{{ route('admin.galleries.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                                Tambah Galeri
                            </a>
                        </div>
                    </div>

                    <!-- Galleries Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($galleries as $gallery)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-48 object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $gallery->title }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($gallery->description, 100) }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $gallery->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $gallery->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $gallery->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="mt-4 flex justify-end space-x-2">
                                    <a href="{{ route('admin.galleries.show', $gallery) }}" class="text-blue-600 hover:text-blue-900 text-sm">Lihat</a>
                                    <a href="{{ route('admin.galleries.edit', $gallery) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus galeri ini?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500">Tidak ada data galeri ditemukan.</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($galleries->hasPages())
                    <div class="mt-6">
                        {{ $galleries->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection