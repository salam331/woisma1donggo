@extends('layouts.app')

@section('title', 'Tambah Tagihan Baru')

@section('content')

    <div class="max-w-4xl mx-auto">

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                    Tambah Tagihan Baru
                </h2>

                <a href="{{ route('admin.invoices.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
            <form method="POST" action="{{ route('admin.invoices.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- LEFT -->
                    <div class="space-y-4">

                        <!-- Nomor Tagihan -->
                        <div>
                            <label for="invoice_number"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tagihan</label>
                            <input id="invoice_number" type="text" name="invoice_number" required
                                value="{{ old('invoice_number') }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                            @error('invoice_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Siswa -->
                        <div>
                            <label for="student_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Siswa</label>
                            <select id="student_id" name="student_id" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                                <option value="">Pilih Siswa</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} - {{ $student->nis }}
                                    </option>
                                @endforeach
                            </select>

                            @error('student_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                            <textarea id="description" name="description" rows="3" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>

                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah
                                (Rp)</label>
                            <input id="amount" type="number" name="amount" required min="0" step="0.01"
                                value="{{ old('amount') }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="space-y-4">

                        <!-- Due Date -->
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jatuh
                                Tempo</label>
                            <input id="due_date" type="date" name="due_date" required value="{{ old('due_date') }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                            @error('due_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select id="status" name="status" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                                <option value="">Pilih Status</option>
                                <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Belum Dibayar
                                </option>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                                <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                            </select>

                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Date -->
                        <div id="payment_date_section" style="display: none;">
                            <label for="payment_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                Pembayaran</label>
                            <input id="payment_date" type="date" name="payment_date" value="{{ old('payment_date') }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                            @error('payment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan
                                (Opsional)</label>
                            <textarea id="notes" name="notes" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>

                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                </div>

                <!-- SUBMIT -->
                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Simpan Tagihan
                    </button>
                </div>

            </form>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status');
            const paymentSection = document.getElementById('payment_date_section');
            const paymentInput = document.getElementById('payment_date');

            function togglePaymentDate() {
                if (statusSelect.value === 'paid') {
                    paymentSection.style.display = 'block';
                    paymentInput.required = true;
                } else {
                    paymentSection.style.display = 'none';
                    paymentInput.required = false;
                    paymentInput.value = '';
                }
            }

            togglePaymentDate();
            statusSelect.addEventListener('change', togglePaymentDate);
        });
    </script>

@endsection