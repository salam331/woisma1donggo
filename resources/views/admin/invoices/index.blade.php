<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Tagihan
            </h2>
            <a href="{{ route('admin.invoices.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Tagihan Baru
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
                            <input type="text" placeholder="Cari tagihan..." class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-64">
                        </div>
                        <div class="flex space-x-2">
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Status</option>
                                <option>Belum Dibayar</option>
                                <option>Sudah Dibayar</option>
                                <option>Terlambat</option>
                            </select>
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Siswa</option>
                                <option>Siswa A</option>
                                <option>Siswa B</option>
                            </select>
                        </div>
                    </div>

                    <!-- Invoices Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Tagihan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($invoices as $invoice)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div>
                                            <div class="font-medium">{{ $invoice->student->name ?? '-' }}</div>
                                            <div class="text-gray-500">{{ $invoice->student->nis ?? '-' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $invoice->due_date->format('d F Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($invoice->status == 'unpaid')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Belum Dibayar</span>
                                        @elseif($invoice->status == 'paid')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Sudah Dibayar</span>
                                        @elseif($invoice->status == 'overdue')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Terlambat</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                            <a href="{{ route('admin.invoices.edit', $invoice) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form method="POST" action="{{ route('admin.invoices.destroy', $invoice) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data tagihan ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($invoices->hasPages())
                    <div class="mt-6">
                        {{ $invoices->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
