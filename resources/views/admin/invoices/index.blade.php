@extends('layouts.app')

@section('title', 'Manajemen Tagihan')

@push('styles')
<style>
    /* Modal backdrop animation */
    .modal-backdrop {
        transition: opacity 0.3s ease;
    }
    
    .modal-backdrop.in {
        opacity: 0.5;
    }
    
    /* Modal content animation */
    .modal-content {
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    }
    
    /* Prevent body scroll when modal is open */
    body.modal-open {
        overflow: hidden;
    }
</style>
@endpush

@section('content')

    {{-- HEADER --}}
    <div class="justify-between items-center mb-6">
        <div x-data="{
                        posX: window.innerWidth - 70,
                        posY: window.innerHeight / 2,
                        dragging: false,
                        startX: 0,
                        startY: 0,
                        clickThreshold: 5,
                        idleTimer: null,
                        screenPadding: 10,
                        {{-- idleDelay: 1500, --}}
                        hidden: false,
                        animationFrame: null,
                        isAnimating: false,

                        startIdleTimer() {
                            clearTimeout(this.idleTimer);
                            this.idleTimer = setTimeout(() => {
                                if (!this.dragging && !this.isAnimating) {
                                    this.snapToEdge();
                                }
                            }, this.idleDelay);
                        },

                        snapToEdge() {
                            if (this.dragging || this.isAnimating) return;

                            const screenWidth = window.innerWidth;
                            const screenHeight = window.innerHeight;

                            // Cancel any ongoing animation
                            this.cancelAnimation();

                            let targetX, targetY = this.posY;

                            // Determine which edge to snap to based on current position
                            if (this.posX < screenWidth / 2) {
                                targetX = this.screenPadding;
                            } else {
                                targetX = screenWidth - 60 - this.screenPadding;
                            }

                            // Keep within vertical bounds
                            targetY = Math.min(
                                Math.max(this.screenPadding, targetY), 
                                screenHeight - 60 - this.screenPadding
                            );

                            // Only animate if significant movement needed
                            if (Math.abs(this.posX - targetX) > 5) {
                                this.animateToPosition(targetX, targetY);
                            }
                        },

                        animateToPosition(targetX, targetY) {
                            this.isAnimating = true;
                            const startX = this.posX;
                            const startY = this.posY;
                            const duration = 400; // ms
                            const startTime = performance.now();

                            const animate = (currentTime) => {
                                // Stop animation if user starts dragging
                                if (this.dragging) {
                                    this.cancelAnimation();
                                    this.isAnimating = false;
                                    return;
                                }

                                const elapsed = currentTime - startTime;
                                const progress = Math.min(elapsed / duration, 1);

                                // Smooth easing function
                                const easeOut = 1 - Math.pow(1 - progress, 4);

                                this.posX = startX + (targetX - startX) * easeOut;
                                this.posY = startY + (targetY - startY) * easeOut;

                                if (progress < 1) {
                                    this.animationFrame = requestAnimationFrame(animate);
                                } else {
                                    this.isAnimating = false;
                                    this.animationFrame = null;
                                }
                            };

                            this.animationFrame = requestAnimationFrame(animate);
                        },

                        cancelAnimation() {
                            if (this.animationFrame) {
                                cancelAnimationFrame(this.animationFrame);
                                this.animationFrame = null;
                            }
                            this.isAnimating = false;
                        },

                        handleMove(dx, dy) {
                            // Cancel any ongoing animation when user starts moving
                            this.cancelAnimation();

                            const newX = this.posX + dx;
                            const newY = this.posY + dy;

                            this.posX = Math.min(
                                Math.max(this.screenPadding, newX), 
                                window.innerWidth - 60 - this.screenPadding
                            );
                            this.posY = Math.min(
                                Math.max(this.screenPadding, newY), 
                                window.innerHeight - 60 - this.screenPadding
                            );
                        },

                        startDrag(clientX, clientY) {
                            this.cancelAnimation();
                            this.startX = clientX;
                            this.startY = clientY;
                            this.dragging = false;
                            clearTimeout(this.idleTimer);
                        },

                        endDrag() {
                            this.dragging = false;
                            // Start idle timer with a small delay to ensure dragging is completely finished
                            setTimeout(() => {
                                if (!this.dragging) {
                                    this.startIdleTimer();
                                }
                            }, 100);
                        },

                        cleanup() {
                            this.cancelAnimation();
                            clearTimeout(this.idleTimer);
                        }
                    }" x-init="startIdleTimer()" @resize.window="if(!dragging && !isAnimating) { snapToEdge(); }"
            x-on:destroy.window="cleanup()" class="fixed z-50 select-none"
            :style="`top: ${posY}px; left: ${posX}px; transition: ${!dragging && !isAnimating ? 'all 0.15s ease-out' : 'none'};`">

            <div @mousedown.prevent="startDrag($event.clientX, $event.clientY)"
                @touchstart.prevent="startDrag($event.touches[0].clientX, $event.touches[0].clientY)" @mousemove.prevent="if($event.buttons === 1){ 
                                let dx = $event.clientX - startX; 
                                let dy = $event.clientY - startY; 
                                if(Math.abs(dx) > clickThreshold || Math.abs(dy) > clickThreshold){ 
                                    dragging = true; 
                                    handleMove(dx, dy);
                                    startX = $event.clientX; 
                                    startY = $event.clientY; 
                                } 
                             }" @touchmove.prevent="let dx = $event.touches[0].clientX - startX; 
                                  let dy = $event.touches[0].clientY - startY; 
                                  if(Math.abs(dx) > clickThreshold || Math.abs(dy) > clickThreshold){ 
                                      dragging = true; 
                                      handleMove(dx, dy);
                                      startX = $event.touches[0].clientX; 
                                      startY = $event.touches[0].clientY; 
                                  }" @mouseup.prevent="
                            if(!dragging){ 
                                window.location.href='{{ route('admin.invoices.create') }}'; 
                            } 
                            endDrag();" @touchend.prevent="
                            if(!dragging){ 
                                window.location.href='{{ route('admin.invoices.create') }}'; 
                            } 
                            endDrag();" @mouseleave="if(dragging) { endDrag(); }" :class="[
                             hidden ? 'opacity-30' : 'opacity-100',
                             dragging ? 'scale-105 bg-blue-600 shadow-xl' : 'scale-100',
                             isAnimating ? 'pointer-events-none' : ''
                         ]"
                class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-lg cursor-pointer hover:bg-blue-600 active:bg-blue-700 transition-all duration-200 transform-gpu touch-none">
                <span class="font-bold text-lg" :class="dragging || isAnimating ? 'scale-110' : 'scale-100'">+</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
            {{-- SEARCH & FILTER --}}
            <form method="GET" action="{{ route('admin.invoices.index') }}"
                class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">

                {{-- SEARCH --}}
                <div class="w-full sm:w-64">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari tagihan / siswa / NIS..."
                        class="w-full border dark:border-gray-700 bg-white dark:bg-gray-800
                            text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2
                            focus:ring focus:ring-indigo-300"
                        {{-- oninput="this.form.submit()" --}}
                    >
                </div>

                <div class="flex gap-2 w-full sm:w-auto">

                    {{-- STATUS --}}
                    <select
                        name="status"
                        class="border dark:border-gray-700 bg-white dark:bg-gray-800
                            text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2"
                        onchange="this.form.submit()"
                    >
                        <option value="">Semua Status</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                    </select>

                    {{-- STUDENT --}}
                    <select
                        name="student_id"
                        class="border dark:border-gray-700 bg-white dark:bg-gray-800
                            text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2"
                        onchange="this.form.submit()"
                    >
                        <option value="">Semua Siswa</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}"
                                {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </form>

            {{-- TABLE --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-responsive">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                    Nomor Tagihan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                    Siswa</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                    Jumlah</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                    Jatuh Tempo</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                    Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($invoices as $invoice)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                                    <td data-label="Nomor Tagihan"
                                        class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $invoice->invoice_number }}
                                    </td>

                                    <td data-label="Siswa" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        <div class="justify-center">
                                            <div class="font-medium">{{ $invoice->student->name ?? '-' }}</div>
                                            <div class="text-gray-500 dark:text-gray-400">{{ $invoice->student->nis ?? '-' }}</div>
                                        </div>
                                        
                                    </td>

                                    <td data-label="Jumlah" class="px-6 py-4 text-sm">
                                        @if($invoice->status == 'paid')
                                            <span class="text-gray-500 dark:text-gray-400 line-through">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                                            <span class="ml-2 text-green-600 font-medium">Lunas</span>
                                        @elseif($invoice->paid_amount > 0)
                                            <div class="flex flex-col">
                                                <span class="text-gray-900 dark:text-gray-100 font-medium">
                                                    Rp {{ number_format($invoice->amount - $invoice->paid_amount, 0, ',', '.') }}
                                                    <span class="text-xs text-gray-500">tersisa</span>
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }} / Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-gray-900 dark:text-gray-100 font-medium">
                                                Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </td>

                                    <td data-label="Jatuh Tempo" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $invoice->due_date->format('d F Y') }}
                                    </td>

                                    <td data-label="Status" class="px-6 py-4 text-sm">
                                        @if($invoice->status == 'unpaid')
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Belum
                                                Dibayar</span>
                                        @elseif($invoice->status == 'paid')
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Sudah
                                                Dibayar</span>
                                        @elseif($invoice->status == 'overdue')
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Terlambat</span>
                                        @endif
                                    </td>

                                    <td data-label="Aksi" class="px-6 py-4 text-center text-sm font-medium">
                                        <!-- DESKTOP -->
                                        <div class="flex items-center justify-center gap-x-4">

                                            {{-- Tombol Lihat (Biru terang) --}}
                                            <a href="{{ route('admin.invoices.show', $invoice) }}"
                                                class="p-2 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 hover:text-blue-900 transition-colors duration-200 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </a>

                                            {{-- Tombol Edit (Kuning terang) --}}
                                            <a href="{{ route('admin.invoices.edit', $invoice) }}"
                                                class="p-2 rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 transition-colors duration-200 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>

                                            {{-- Tombol Bayar (Hijau terang) - hanya untuk unpaid/overdue --}}
                                            @if(in_array($invoice->status, ['unpaid', 'overdue']))
                                                <button type="button"
                                                    onclick="openPaymentModal({{ $invoice->id }}, '{{ $invoice->invoice_number }}', '{{ $invoice->student->name ?? '-' }}', {{ $invoice->amount }}, '{{ $invoice->due_date->format('d F Y') }}', {{ $invoice->amount - ($invoice->paid_amount ?? 0) }})"
                                                    class="p-2 rounded-full bg-green-100 text-green-700 hover:bg-green-200 hover:text-green-900 transition-colors duration-200 shadow-sm"
                                                    title="Bayar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                                    </svg>
                                                </button>
                                            @endif

                                            {{-- Tombol Hapus (Merah terang) --}}
                                            <form method="POST" action="{{ route('admin.invoices.destroy', $invoice) }}" class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 rounded-full bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-900 transition-colors duration-200 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                        data tagihan ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                {{-- PAGINATION --}}
                @if($invoices->hasPages())
                    <div class="p-4">
                        {{ $invoices->links() }}
                    </div>
                @endif
            </div>

    {{-- Payment Modal --}}
    <div id="paymentModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity modal-backdrop" onclick="closePaymentModal()"></div>
        
        <!-- Modal Panel -->
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg modal-content"
                    id="paymentModalPanel">
                    
                    {{-- Modal Header --}}
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-green-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modalTitle">
                                    Pembayaran Tagihan
                                </h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Silakan lengkapi data pembayaran berikut:</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Invoice Details --}}
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Nomor Tagihan:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100" id="modalInvoiceNumber"></p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Siswa:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100" id="modalStudentName"></p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Total Tagihan:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100" id="modalTotalAmount"></p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Jatuh Tempo:</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100" id="modalDueDate"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Form --}}
                    <form id="paymentForm" method="POST" action="">
                        @csrf
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="space-y-4">
                                {{-- Payment Amount --}}
                                <div>
                                    <label for="pay_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Jumlah Pembayaran <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative mt-1 rounded-lg shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="pay_amount" id="pay_amount" min="1" required
                                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 pl-10 pr-3 py-2 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                            placeholder="0" step="1" min="1">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Sisa tagihan: <span id="remainingAmount" class="font-medium text-green-600">Rp 0</span>
                                    </p>
                                </div>

                                {{-- Payment Date --}}
                                <div>
                                    <label for="payment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Tanggal Pembayaran <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="payment_date" id="payment_date" required
                                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        value="{{ date('Y-m-d') }}">
                                </div>

                                {{-- Notes --}}
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Catatan
                                    </label>
                                    <textarea name="notes" id="notes" rows="3" maxlength="500" placeholder="Catatan pembayaran (opsional)..."
                                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maksimal 500 karakter</p>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Footer --}}
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit" 
                                class="inline-flex w-full justify-center rounded-lg border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                Konfirmasi Pembayaran
                            </button>
                            <button type="button" onclick="closePaymentModal()"
                                class="mt-3 inline-flex w-full justify-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for Modal --}}
    <script>
        let remainingAmount = 0;

        function openPaymentModal(invoiceId, invoiceNumber, studentName, amount, dueDate, remaining) {
            // Store remaining amount
            remainingAmount = remaining;
            
            // Set invoice details
            document.getElementById('modalInvoiceNumber').textContent = invoiceNumber;
            document.getElementById('modalStudentName').textContent = studentName;
            document.getElementById('modalTotalAmount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
            document.getElementById('modalDueDate').textContent = dueDate;
            
            // Update remaining amount display
            document.getElementById('remainingAmount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(remainingAmount);
            
            // Set form action
            document.getElementById('paymentForm').action = '/admin/invoices/' + invoiceId + '/payment';
            
            // Reset form and set default payment amount to remaining
            document.getElementById('paymentForm').reset();
            document.getElementById('payment_date').value = new Date().toISOString().split('T')[0];
            document.getElementById('pay_amount').value = remainingAmount;
            
            // Show modal
            document.getElementById('paymentModal').classList.remove('hidden');
            document.body.classList.add('modal-open');
            
            // Prevent event propagation
            event.stopPropagation();
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.body.classList.remove('modal-open');
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePaymentModal();
            }
        });

        // Close modal when clicking outside
        document.getElementById('paymentModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closePaymentModal();
            }
        });

        // Form validation - ensure payment doesn't exceed remaining amount
        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            const payAmount = parseFloat(document.getElementById('pay_amount').value);
            if (payAmount > remainingAmount) {
                event.preventDefault();
                alert('Jumlah pembayaran tidak dapat melebihi sisa tagihan (Rp ' + new Intl.NumberFormat('id-ID').format(remainingAmount) + ')');
            }
        });
    </script>

@endsection

