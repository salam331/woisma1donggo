<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Kelas
            </h2>
            <a href="{{ route('admin.classes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Kelas Baru
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
                            <input type="text" placeholder="Cari kelas..." class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-64">
                        </div>
                        <div class="flex space-x-2">
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Tingkat</option>
                                <option>Kelas 1</option>
                                <option>Kelas 2</option>
                                <option>Kelas 3</option>
                            </select>
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Wali Kelas</option>
                                <option>Ada Wali Kelas</option>
                                <option>Tanpa Wali Kelas</option>
                            </select>
                        </div>
                    </div>

                    <!-- Classes Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wali Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($classes as $class)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $class->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $class->grade_level }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $class->teacher ? $class->teacher->name : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $class->students->count() }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $class->description ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.classes.show', $class) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                            <a href="{{ route('admin.classes.edit', $class) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
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
        </div>
    </div>
</x-admin-layout>
