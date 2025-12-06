@extends('layouts.app')

@section('title', 'Manajemen Tagihan')

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
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
                <div class="mb-4 sm:mb-0">
                    <input type="text" placeholder="Cari tagihan..."
                        class="border dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2 w-full sm:w-64">
                </div>
                <div class="flex space-x-2">
                    <select
                        class="border dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2">
                        <option>Semua Status</option>
                        <option>Belum Dibayar</option>
                        <option>Sudah Dibayar</option>
                        <option>Terlambat</option>
                    </select>

                    <select
                        class="border dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2">
                        <option>Semua Siswa</option>
                        <option>Siswa A</option>
                        <option>Siswa B</option>
                    </select>
                </div>
            </div>

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
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
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
                                        <div class="font-medium">{{ $invoice->student->name ?? '-' }}</div>
                                        <div class="text-gray-500 dark:text-gray-400">{{ $invoice->student->nis ?? '-' }}</div>
                                    </td>

                                    <td data-label="Jumlah" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        Rp {{ number_format($invoice->amount, 0, ',', '.') }}
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

                                    <td data-label="Aksi" class="px-6 py-4 text-right text-sm font-medium">
                                        <!-- DESKTOP -->
                                        <div class="hidden sm:flex justify-end space-x-2">
                                            <a href="{{ route('admin.invoices.show', $invoice) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:underline">Lihat</a>
                                            <a href="{{ route('admin.invoices.edit', $invoice) }}"
                                                class="text-indigo-600 dark:text-indigo-400 hover:underline">Edit</a>
                                            <form method="POST" action="{{ route('admin.invoices.destroy', $invoice) }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?')">Hapus</button>
                                            </form>
                                        </div>

                                        <!-- MOBILE -->
                                        <div class="mobile-actions sm:hidden">
                                            <a href="{{ route('admin.invoices.show', $invoice) }}"
                                                class="px-3 py-1 text-xs rounded bg-blue-500 text-white">Lihat</a>
                                            <a href="{{ route('admin.invoices.edit', $invoice) }}"
                                                class="px-3 py-1 text-xs rounded bg-indigo-500 text-white">Edit</a>
                                            <form method="POST" action="{{ route('admin.invoices.destroy', $invoice) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1 text-xs rounded bg-red-500 text-white">Hapus</button>
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

@endsection