<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Jadwal
            </h2>
            <a href="{{ route('admin.schedules.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Jadwal Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <!-- Search Bar (optional, bisa dipakai nanti) -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0 w-full sm:w-auto">
                            <input type="text" placeholder="Cari jadwal..." 
                                   class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-64">
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mapel</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($schedules as $schedule)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $schedule->id }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $schedule->class->name }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $schedule->subject->name }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $schedule->teacher->name }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{-- nama hari dengan format indonesian --}}
                                        @php
                                            $dayTranslations = [
                                                'monday' => 'Senin',
                                                'tuesday' => 'Selasa',
                                                'wednesday' => 'Rabu',
                                                'thursday' => 'Kamis',
                                                'friday' => 'Jumat',
                                                'saturday' => 'Sabtu',
                                                'sunday' => 'Minggu',
                                            ];
                                        @endphp
                                        {{ $dayTranslations[$schedule->day] ?? $schedule->day }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.schedules.show', $schedule) }}" 
                                               class="text-blue-600 hover:text-blue-900">Lihat</a>

                                            <a href="{{ route('admin.schedules.edit', $schedule) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>

                                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" 
                                                  method="POST" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Hapus jadwal ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada jadwal ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($schedules->hasPages())
                    <div class="mt-6">
                        {{ $schedules->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
