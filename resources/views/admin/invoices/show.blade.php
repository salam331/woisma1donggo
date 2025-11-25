@extends('layouts.app')

@section('title', 'Detail Tagihan: ' . $invoice->invoice_number)

@section('content')

    <div class="bg-white shadow-sm rounded-lg p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Detail Tagihan: {{ $invoice->invoice_number }}
            </h2>

            <div class="flex space-x-2">
                <a href="{{ route('admin.invoices.edit', $invoice) }}"
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit Tagihan
                </a>
                <a href="{{ route('admin.invoices.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- INFORMASI TAGIHAN -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tagihan</h3>

                <div class="space-y-4">
                    <div class="border-t pt-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nomor Tagihan</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $invoice->invoice_number }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Siswa</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $invoice->student->name ?? '-' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">NIS Siswa</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $invoice->student->nis ?? '-' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jumlah</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jatuh Tempo</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $invoice->due_date->format('d F Y') }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">

                                    @if($invoice->status == 'unpaid')
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Belum Dibayar
                                        </span>
                                    @elseif($invoice->status == 'paid')
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Sudah Dibayar
                                        </span>
                                    @elseif($invoice->status == 'overdue')
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Terlambat
                                        </span>
                                    @endif

                                </dd>
                            </div>

                            @if($invoice->payment_date)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Pembayaran</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $invoice->payment_date->format('d F Y') }}
                                    </dd>
                                </div>
                            @endif

                        </dl>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $invoice->description }}</dd>
                    </div>

                    @if($invoice->notes)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $invoice->notes }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- INFORMASI TAMBAHAN -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h3>

                <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-700 space-y-2">
                    <p><strong>ID Tagihan:</strong> {{ $invoice->id }}</p>
                    <p><strong>Dibuat:</strong> {{ $invoice->created_at->format('d F Y H:i') }}</p>
                    <p><strong>Terakhir Update:</strong> {{ $invoice->updated_at->format('d F Y H:i') }}</p>
                </div>

                <!-- CETAK / DOWNLOAD -->
                <div class="mt-6">
                    <h4 class="text-md font-semibold text-gray-900 mb-3">Cetak / Download</h4>
                    <div class="space-y-2">
                        <button class="w-full text-left px-4 py-2 bg-white border rounded-md hover:bg-gray-50">
                            Cetak Tagihan
                        </button>
                        <button class="w-full text-left px-4 py-2 bg-white border rounded-md hover:bg-gray-50">
                            Download PDF
                        </button>
                    </div>
                </div>

                <!-- AKSI CEPAT -->
                <div class="mt-6">
                    <h4 class="text-md font-semibold text-gray-900 mb-3">Aksi Cepat</h4>
                    <div class="space-y-2">
                        <a href="{{ route('admin.invoices.edit', $invoice) }}"
                            class="block w-full text-left px-4 py-2 bg-white border rounded-md hover:bg-gray-50">
                            Edit Tagihan
                        </a>

                        @if($invoice->status != 'paid')
                            <button
                                class="block w-full text-left px-4 py-2 text-green-700 bg-white border rounded-md hover:bg-green-50">
                                Tandai Sudah Dibayar
                            </button>
                        @endif

                        <button
                            class="block w-full text-left px-4 py-2 text-red-700 bg-white border rounded-md hover:bg-red-50">
                            Hapus Tagihan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection