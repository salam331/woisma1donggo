@extends('layouts.app')

@section('title', 'Edit Tagihan')

@section('content')

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                        Edit Tagihan: {{ $invoice->invoice_number }}
                    </h2>

                    <a href="{{ route('admin.invoices.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.invoices.update', $invoice) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- LEFT COLUMN --}}
                        <div class="space-y-4">

                            {{-- Invoice Number --}}
                            <div>
                                <label for="invoice_number"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nomor Tagihan
                                </label>

                                <input id="invoice_number" type="text" name="invoice_number"
                                    value="{{ old('invoice_number', $invoice->invoice_number) }}" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                              rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                                @error('invoice_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Student --}}
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Siswa
                                </label>

                                <select id="student_id" name="student_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                                    <option value="">Pilih Siswa</option>

                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id', $invoice->student_id) == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }} - {{ $student->nis }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Deskripsi
                                </label>

                                <textarea id="description" name="description" rows="3" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                                    {{ old('description', $invoice->description) }}
                                </textarea>

                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Amount --}}
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jumlah (Rp)
                                </label>

                                <input id="amount" type="number" min="0" step="0.01" name="amount"
                                    value="{{ old('amount', $invoice->amount) }}" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">

                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- RIGHT COLUMN --}}
                        <div class="space-y-4">

                            {{-- Due Date --}}
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jatuh Tempo
                                </label>

                                <input id="due_date" type="date" name="due_date"
                                    value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">

                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status
                                </label>

                                <select id="status" name="status" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                                    <option value="">Pilih Status</option>
                                    <option value="unpaid" {{ old('status', $invoice->status) == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                                    <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>
                                        Sudah Dibayar</option>
                                    <option value="overdue" {{ old('status', $invoice->status) == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                                </select>

                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Payment Date --}}
                            <div id="payment_date_section"
                                style="display: {{ old('status', $invoice->status) == 'paid' ? 'block' : 'none' }};">
                                <label for="payment_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal Pembayaran
                                </label>

                                <input id="payment_date" type="date" name="payment_date"
                                    value="{{ old('payment_date', $invoice->payment_date ? $invoice->payment_date->format('Y-m-d') : '') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">

                                @error('payment_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Notes --}}
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Catatan (Opsional)
                                </label>

                                <textarea id="notes" name="notes" rows="3"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md">
                                    {{ old('notes', $invoice->notes) }}
                                </textarea>

                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Tagihan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Script status paid --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status');
            const paymentSection = document.getElementById('payment_date_section');
            const paymentInput = document.getElementById('payment_date');

            statusSelect.addEventListener('change', function () {
                if (this.value === 'paid') {
                    paymentSection.style.display = 'block';
                    paymentInput.required = true;
                } else {
                    paymentSection.style.display = 'none';
                    paymentInput.required = false;
                    paymentInput.value = '';
                }
            });
        });
    </script>

@endsection