<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800">
                Manajemen Orang Tua
            </h2>
            <a href="{{ route('admin.parents.create') }}">
                <button
                    type="button"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                    Tambah Orang Tua
                </button>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                <div class="p-6">

                    <!-- Search & Filter -->
                    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <input
                            type="text"
                            placeholder="Cari orang tua..."
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-80 focus:ring focus:ring-blue-200 focus:border-blue-500"
                        >

                        <select
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-48 focus:ring focus:ring-blue-200 focus:border-blue-500">
                            <option>Semua Hubungan</option>
                            <option>Ayah</option>
                            <option>Ibu</option>
                            <option>Wali</option>
                        </select>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Telepon</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Hubungan</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Jumlah Anak</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">

                                @forelse($parents as $parent)
                                    <tr class="hover:bg-gray-50 transition">
                                        <!-- Photo -->
                                        <td class="px-6 py-4">
                                            <div class="h-12 w-12">
                                                @if ($parent->photo)
                                                    <img src="{{ asset('storage/' . $parent->photo) }}"
                                                         class="h-12 w-12 rounded-full object-cover shadow" alt="">
                                                @else
                                                    <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center shadow">
                                                        <span class="text-lg font-semibold text-gray-700">
                                                            {{ substr($parent->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Name -->
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                            {{ $parent->name }}
                                        </td>

                                        <!-- Email -->
                                        <td class="px-6 py-4 text-sm text-gray-800">
                                            {{ $parent->email }}
                                        </td>

                                        <!-- Phone -->
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $parent->phone ?? '-' }}
                                        </td>

                                        <!-- Relationship -->
                                        <td class="px-6 py-4">
                                            <span class="
                                                inline-flex px-3 py-1 rounded-full text-xs font-bold
                                                @if($parent->relationship === 'father')
                                                    bg-blue-100 text-blue-700
                                                @elseif($parent->relationship === 'mother')
                                                    bg-pink-100 text-pink-700
                                                @else
                                                    bg-purple-100 text-purple-700
                                                @endif
                                            ">
                                                @if($parent->relationship === 'father') Ayah
                                                @elseif($parent->relationship === 'mother') Ibu
                                                @else Wali @endif
                                            </span>
                                        </td>

                                        <!-- Children Count -->
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $parent->students->count() }}
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 text-right text-sm">
                                            <div class="flex justify-end space-x-3">

                                                <a href="{{ route('admin.parents.show', $parent) }}"
                                                   class="text-blue-600 hover:text-blue-800 font-semibold">
                                                    Lihat
                                                </a>

                                                <a href="{{ route('admin.parents.edit', $parent) }}"
                                                   class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                                    Edit
                                                </a>

                                                <form method="POST"
                                                      action="{{ route('admin.parents.destroy', $parent) }}"
                                                      onsubmit="return confirm('Yakin ingin menghapus orang tua ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-600 hover:text-red-800 font-semibold">
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 text-sm">
                                            Tidak ada data orang tua ditemukan.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($parents->hasPages())
                        <div class="mt-6">
                            {{ $parents->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
