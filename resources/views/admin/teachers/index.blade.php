<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Guru
            </h2>
            <a href="{{ route('admin.teachers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Guru Baru
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
                            <input type="text" placeholder="Cari guru..." class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-64">
                        </div>
                        <div class="flex space-x-2">
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Gender</option>
                                <option>Laki-laki</option>
                                <option>Perempuan</option>
                            </select>
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Mata Pelajaran</option>
                                <option>Matematika</option>
                                <option>Bahasa Indonesia</option>
                                <option>Bahasa Inggris</option>
                            </select>
                        </div>
                    </div>

                    <!-- Teachers Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spesialisasi</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($teachers as $teacher)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($teacher->photo)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}">
                                            @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">{{ substr($teacher->name, 0, 1) }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $teacher->nip }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $teacher->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $teacher->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $teacher->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ $teacher->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $teacher->subject_specialization ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data guru ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($teachers->hasPages())
                    <div class="mt-6">
                        {{ $teachers->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
