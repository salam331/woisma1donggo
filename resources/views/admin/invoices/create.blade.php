<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Tagihan Baru
            </h2>
            <a href="{{ route('admin.invoices.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.invoices.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <!-- Invoice Number -->
                                <div>
                                    <label for="invoice_number" class="block text-sm font-medium text-gray-700">Nomor Tagihan</label>
                                    <input id="invoice_number" type="text" name="invoice_number" value="{{ old('invoice_number') }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('invoice_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Student -->
                                <div>
                                    <label for="student_id" class="block text-sm font-medium text-gray-700">Siswa</label>
                                    <select id="student_id" name="student_id" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
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

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea id="description" name="description" rows="3" required
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Amount -->
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                                    <input id="amount" type="number" name="amount" value="{{ old('amount') }}" required min="0" step="0.01"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <!-- Due Date -->
                                <div>
                                    <label for="due_date" class="block text-sm font-medium text-gray-700">Jatuh Tempo</label>
                                    <input id="due_date" type="date" name="due_date" value="{{ old('due_date') }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('due_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="status" name="status" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Status</option>
                                        <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                                        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                                        <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Date (only show if status is paid) -->
                                <div id="payment_date_section" style="display: none;">
                                    <label for="payment_date" class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                                    <input id="payment_date" type="date" name="payment_date" value="{{ old('payment_date') }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('payment_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                    <textarea id="notes" name="notes" rows="3"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Tagihan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const paymentDateSection = document.getElementById('payment_date_section');
            const paymentDateInput = document.getElementById('payment_date');

            statusSelect.addEventListener('change', function() {
                if (this.value === 'paid') {
                    paymentDateSection.style.display = 'block';
                    paymentDateInput.required = true;
                } else {
                    paymentDateSection.style.display = 'none';
                    paymentDateInput.required = false;
                    paymentDateInput.value = '';
                }
            });
        });
    </script>
</x-admin-layout>
