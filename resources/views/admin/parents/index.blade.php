@extends('layouts.app')

@section('title', 'Manajemen Orang Tua')

@section('content')

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                        window.location.href='{{ route('admin.parents.create') }}'; 
                    } 
                    endDrag();" @touchend.prevent="
                    if(!dragging){ 
                        window.location.href='{{ route('admin.parents.create') }}'; 
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

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">

        <div class="p-2">

            <!-- Search & Filter -->
            <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <input type="text" placeholder="Cari orang tua..."
                    class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg px-4 py-2 w-full sm:w-80 focus:ring focus:ring-blue-200 focus:border-blue-500">

                <select
                    class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg px-4 py-2 w-full sm:w-48 focus:ring focus:ring-blue-200 focus:border-blue-500">
                    <option>Semua Hubungan</option>
                    <option>Ayah</option>
                    <option>Ibu</option>
                    <option>Wali</option>
                </select>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">
                                Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">
                                Telepon</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">
                                Hubungan</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">
                                Jumlah Anak</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">
                                Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">

                        @forelse($parents as $parent)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                                <!-- Photo -->
                                <td class="px-6 py-4">
                                    <div class="h-12 w-12">
                                        @if ($parent->photo)
                                            <img src="{{ asset('storage/' . $parent->photo) }}"
                                                class="h-12 w-12 rounded-full object-cover shadow" alt="">
                                        @else
                                            <div
                                                class="h-12 w-12 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center shadow">
                                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-100">
                                                    {{ substr($parent->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Name -->
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $parent->name }}
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-300">
                                    {{ $parent->email }}
                                </td>

                                <!-- Phone -->
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $parent->phone ?? '-' }}
                                </td>

                                <!-- Relationship -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold
                                                @if($parent->relationship === 'father')
                                                    bg-blue-100 text-blue-700
                                                @elseif($parent->relationship === 'mother')
                                                    bg-pink-100 text-pink-700
                                                @else
                                                    bg-purple-100 text-purple-700
                                                @endif
                                            ">
                                        @if($parent->relationship === 'father') Ayah
                                        @elseif($parent->relationship === 'mother') Ibu
                                        @else Wali @endif
                                    </span>
                                </td>

                                <!-- Children Count -->
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $parent->students->count() }}
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right text-sm">
                                    <div class="flex justify-end space-x-3">

                                        <a href="{{ route('admin.parents.show', $parent) }}"
                                            class="text-blue-600 hover:text-blue-800 font-semibold">
                                            Lihat
                                        </a>

                                        <a href="{{ route('admin.parents.edit', $parent) }}"
                                            class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('admin.parents.destroy', $parent) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus orang tua ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-800 font-semibold">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 text-sm">
                                    Tidak ada data orang tua ditemukan.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($parents->hasPages())
                <div class="mt-6">
                    {{ $parents->links() }}
                </div>
            @endif

        </div>
    </div>

@endsection