@extends('layouts.app')

@section('title', 'Manajemen Mata Pelajaran')

@section('content')

    <div>
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
                            window.location.href='{{ route('admin.subjects.create') }}'; 
                        } 
                        endDrag();" @touchend.prevent="
                        if(!dragging){ 
                            window.location.href='{{ route('admin.subjects.create') }}'; 
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
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

        <!-- Search & Filter -->
        <form method="GET" action="{{ route('admin.subjects.index') }}"
            class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">

            {{-- SEARCH --}}
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari Kode atau Nama Mata Pelajaran..."
                {{-- oninput="this.form.submit()" --}}
                class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                    rounded-lg px-4 py-2 w-full sm:w-64"
            >

            {{-- FILTER GURU --}}
            <select
                name="teacher_id"
                onchange="this.form.submit()"
                class="border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200
                    rounded-lg px-4 py-2"
            >
                <option value="">Semua Guru</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}"
                        {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>

        </form>


        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-responsive">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            Kode
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            Nama Mata Pelajaran
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            Guru Pengajar
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            Jumlah Jadwal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            Deskripsi
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($subjects as $subject)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                            <td class="px-6 py-4" data-label="Kode">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    {{ $subject->code }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100" data-label="Nama">
                                {{ $subject->name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300" data-label="Guru">
                                {{ $subject->teacher ? $subject->teacher->name : '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400" data-label="Jadwal">
                                {{ $subject->schedules->count() }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                                data-label="Deskripsi">
                                {{ $subject->description ?? '-' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" data-label="Aksi">
                                <div class="flex items-center justify-center gap-x-4">

                                    {{-- Tombol Lihat (Biru terang) --}}
                                    <a href="{{ route('admin.subjects.show', $subject) }}"
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
                                    <a href="{{ route('admin.subjects.edit', $subject) }}"
                                        class="p-2 rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 transition-colors duration-200 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>

                                    {{-- Tombol Hapus (Merah terang) --}}
                                    <form method="POST" action="{{ route('admin.subjects.destroy', $subject) }}" class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')"
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
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data mata pelajaran ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- Pagination -->
        @if($subjects->hasPages())
            <div class="mt-6">
                {{ $subjects->links() }}
            </div>
        @endif
    </div>

@endsection