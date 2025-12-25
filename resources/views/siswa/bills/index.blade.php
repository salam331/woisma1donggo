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
                    <!-- Desktop Table View -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($bills as $bill)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $bill->description ?? 'Pembayaran Sekolah' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Rp {{ number_format($bill->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($bill->payment_date)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Belum Lunas
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $bill->notes ?? '-' }}
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
                                    <h3 class="text-sm font-medium text-gray-900">{{ $bill->description ?? 'Pembayaran Sekolah' }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="ml-2">
                                    @if($bill->payment_date)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Belum Lunas
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="text-lg font-semibold text-gray-900">
                                    Rp {{ number_format($bill->amount, 0, ',', '.') }}
                                </div>
                                @if($bill->notes)
                                    <div class="text-sm text-gray-500 mt-1">
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

                    <!-- Summary Card -->
                    <div class="mt-8 bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Tagihan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm font-medium text-gray-500">Total Tagihan</div>
                                <div class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($bills->sum('amount'), 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm font-medium text-gray-500">Sudah Dibayar</div>
                                <div class="text-2xl font-bold text-green-600">
                                    Rp {{ number_format($bills->where('payment_date', '!=', null)->sum('amount'), 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="text-sm font-medium text-gray-500">Belum Dibayar</div>
                                <div class="text-2xl font-bold text-red-600">
                                    Rp {{ number_format($bills->where('payment_date', null)->sum('amount'), 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
