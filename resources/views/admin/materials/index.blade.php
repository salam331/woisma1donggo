<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Materi Pelajaran
            </h2>
            <a href="{{ route('admin.materials.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Materi Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Search and Filter -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <input type="text" placeholder="Cari materi..." class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-64">
                        </div>
                        <div class="flex space-x-2">
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Mata Pelajaran</option>
                                <option>Matematika</option>
                                <option>Bahasa Indonesia</option>
                            </select>
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Guru</option>
                                <option>Ada Guru</option>
                                <option>Tanpa Guru</option>
                            </select>
                        </div>
                    </div>

                    <!-- Materials Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe File</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($materials as $material)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if(str_contains($material->file_type, 'image'))
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $material->file_path) }}" alt="">
                                                @elseif(str_contains($material->file_type, 'pdf'))
                                                    <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                                        <span class="text-red-600 font-bold">PDF</span>
                                                    </div>
                                                @elseif(str_contains($material->file_type, 'video'))
                                                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <span class="text-blue-600 font-bold">VID</span>
                                                    </div>
                                                @else
                                                    <div class="h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                        <span class="text-gray-600 font-bold">DOC</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $material->title }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($material->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $material->subject->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $material->teacher->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $material->file_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format(Storage::disk('public')->size($material->file_path) / 1024, 1) }} KB
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.materials.show', $material) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                            <a href="{{ route('admin.materials.edit', $material) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <a href="{{ route('admin.materials.download', $material) }}" class="text-green-600 hover:text-green-900">Download</a>
                                            <form method="POST" action="{{ route('admin.materials.destroy', $material) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data materi ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($materials->hasPages())
                    <div class="mt-6">
                        {{ $materials->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
