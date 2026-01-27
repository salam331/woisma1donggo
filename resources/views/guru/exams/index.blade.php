@extends('layouts.app')

@section('title', 'Ujian - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
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
                            window.location.href='{{ route('guru.exams.create') }}'; 
                        } 
                        endDrag();" @touchend.prevent="
                        if(!dragging){ 
                            window.location.href='{{ route('guru.exams.create') }}'; 
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
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                    @if($exams->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Ujian
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Mata Pelajaran
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Kelas
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tanggal & Waktu
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Durasi
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($exams as $exam)
                                    <tr>

                                        <td data-label="Ujian" class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $exam->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Skor: {{ $exam->total_score }}
                                            </div>
                                            @if($exam->description)
                                                <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                    {{ Str::limit($exam->description, 50) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td data-label="Mata pelajaran" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $exam->subject->name ?? 'N/A' }}
                                        </td>
                                        <td data-label="Kelas" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $exam->schoolClass->name ?? 'N/A' }}
                                        </td>
                                        <td data-label="Tanggal dan Waktu" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            <div>{{ $exam->exam_date ? $exam->exam_date->format('d M Y') : 'N/A' }}</div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500">
                                                {{-- {{ $exam->start_time ?? 'N/A' }} - {{ $exam->end_time ?? 'N/A' }} --}}
                                                {{ $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('H:i') : 'N/A' }}
                                                -
                                                {{ $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('H:i') : 'N/A' }}

                                            </div>
                                        </td>
                                        <td data-label="Durasi" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            @php
                                                $duration = 'N/A';
                                                if($exam->start_time && $exam->end_time) {
                                                    // $start = \Carbon\Carbon::parse($exam->exam_date . ' ' . $exam->start_time);
                                                    // $end = \Carbon\Carbon::parse($exam->exam_date . ' ' . $exam->end_time);
                                                    $start = \Carbon\Carbon::parse($exam->start_time);
                                                    $end = \Carbon\Carbon::parse($exam->end_time);
                                                    $duration = $end->diffInMinutes($start) . ' menit';
                                                }
                                            @endphp
                                            {{ $duration }}
                                        </td>
                                        <td data-label="Aksi" class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                            <!-- DESKTOP -->
                                            <div class="flex items-center justify-center gap-x-4">

                                                {{-- Tombol Lihat --}}
                                                <a href="{{ route('guru.exams.show', $exam) }}"
                                                    class="p-2 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 hover:text-blue-900 transition-colors duration-200 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </a>

                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('guru.exams.edit', $exam) }}"
                                                    class="p-2 rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 transition-colors duration-200 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </a>

                                                {{-- Tombol Hapus --}}
                                                <form method="POST" action="{{ route('guru.exams.destroy', $exam) }}"
                                                    class="inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus ujian ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 rounded-full bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-900 transition-colors duration-200 shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21
                                                                c.342.052.682.107 1.022.166m-1.022-.165
                                                                L18.16 19.673a2.25 2.25 0 01-2.244 2.077
                                                                H8.084a2.25 2.25 0 01-2.244-2.077
                                                                L4.772 5.79m14.456 0
                                                                a48.108 48.108 0 00-3.478-.397m-12 .562
                                                                c.34-.059.68-.114 1.022-.165m0 0
                                                                a48.11 48.11 0 013.478-.397m7.5 0v-.916
                                                                c0-1.18-.91-2.164-2.09-2.201
                                                                a51.964 51.964 0 00-3.32 0
                                                                c-1.18.037-2.09 1.022-2.09 2.201v.916
                                                                m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>

                                            </div>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $exams->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-file-alt text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada ujian</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-6">Anda belum membuat ujian.</p>
                            <a href="{{ route('guru.exams.create') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                                Buat Ujian Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
