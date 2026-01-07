@extends('layouts.app')

@section('title', 'Tagihan Pembayaran')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Tagihan Pembayaran</h1>
                </div>

                @if($bills->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada tagihan</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada tagihan pembayaran yang tersedia.</p>
                    </div>
                @else
                    <!-- Summary Card -->
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Ringkasan Tagihan</h3>
                        <dl class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Total Tagihan</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($bills->sum('amount'), 0, ',', '.') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Sudah Dibayar</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    Rp {{ number_format($bills->sum('paid_amount') ?? 0, 0, ',', '.') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Sisa Tagihan</dt>
                                <dd class="text-sm font-medium text-green-600">
                                    Rp {{ number_format($bills->sum('amount') - ($bills->sum('paid_amount') ?? 0), 0, ',', '.') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 dark:text-gray-400">Status</dt>
                                <dd class="text-sm font-medium">
                                    @if($bills->where('status', 'paid')->count() == $bills->count())
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Lunas
                                        </span>
                                    @elseif($bills->sum('paid_amount') > 0)
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Cicilan
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Tagihan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sudah Dibayar</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($bills as $bill)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $bill->invoice_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $bill->description ?? 'Pembayaran Sekolah' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Rp {{ number_format($bill->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600">
                                            Rp {{ number_format($bill->paid_amount ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                            Rp {{ number_format($bill->amount - ($bill->paid_amount ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($bill->status == 'paid')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Lunas
                                                </span>
                                            @elseif($bill->paid_amount > 0)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Cicilan
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Belum Dibayar
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($bills->hasPages())
                        <div class="mt-4">
                            {{ $bills->links() }}
                        </div>
                        @endif
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden space-y-4">
                        @foreach($bills as $bill)
                        <div class="bg-white rounded-lg shadow-sm border p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $bill->invoice_number }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="ml-2">
                                    @if($bill->status == 'paid')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Lunas
                                        </span>
                                    @elseif($bill->paid_amount > 0)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Cicilan
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="text-sm text-gray-500">{{ $bill->description ?? 'Pembayaran Sekolah' }}</div>
                                <div class="text-lg font-semibold text-gray-900 mt-1">
                                    Rp {{ number_format($bill->amount, 0, ',', '.') }}
                                </div>
                                <div class="mt-2 grid grid-cols-2 gap-2 text-sm">
                                    <div>
                                        <span class="text-gray-500">Sudah Dibayar:</span>
                                        <span class="font-medium text-gray-700">Rp {{ number_format($bill->paid_amount ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Sisa:</span>
                                        <span class="font-medium text-green-600">Rp {{ number_format($bill->amount - ($bill->paid_amount ?? 0), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                @if($bill->notes)
                                    <div class="mt-2 text-sm text-gray-500">
                                        Catatan: {{ $bill->notes }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach

                        <!-- Mobile Pagination -->
                        @if($bills->hasPages())
                        <div class="mt-4 flex justify-center">
                            {{ $bills->links() }}
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
