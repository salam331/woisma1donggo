@extends('layouts.app')

@section('title', 'Manajemen Guru')

@section('content')
    {{-- <div class="py-12"> --}}
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
                    @touchstart.prevent="startDrag($event.touches[0].clientX, $event.touches[0].clientY)"
                    @mousemove.prevent="if($event.buttons === 1){ 
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
                    window.location.href='{{ route('admin.teachers.create') }}'; 
                } 
                endDrag();" @touchend.prevent="
                if(!dragging){ 
                    window.location.href='{{ route('admin.teachers.create') }}'; 
                } 
                endDrag();" @mouseleave="if(dragging) { endDrag(); }" :class="[
                 hidden ? 'opacity-30' : 'opacity-100',
                 dragging ? 'scale-105 bg-blue-600 shadow-xl' : 'scale-100',
                 isAnimating ? 'pointer-events-none' : ''
             ]" class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-lg cursor-pointer hover:bg-blue-600 active:bg-blue-700 transition-all duration-200 transform-gpu touch-none">
                    <span class="font-bold text-lg" :class="dragging || isAnimating ? 'scale-110' : 'scale-100'">+</span>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-2">
                    <!-- Search and Filter -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <input type="text" placeholder="Cari guru..."
                                class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-64">
                        </div>
                        <div class="flex space-x-2">
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Gender</option>
                                <option>Laki-laki</option>
                                <option>Perempuan</option>
                            </select>
                            <select class="border border-gray-300 rounded-lg px-4 py-2">
                                <option>Semua Mapel</option>
                                <option>Matematika</option>
                                <option>Bahasa Indonesia</option>
                                <option>Bahasa Inggris</option>
                            </select>
                        </div>
                    </div>

                    <!-- Teachers Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-responsive">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIP</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Spesialisasi</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($teachers as $teacher)
                                    <tr class="hover:bg-gray-50">
                                        
                                        {{-- FOTO --}}
                                        <td class="px-6 py-4 whitespace-nowrap" data-label="Foto">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($teacher->photo)
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-700">
                                                            {{ substr($teacher->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- NIP --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                            data-label="NIP">
                                            {{ $teacher->nip }}
                                        </td>

                                        {{-- NAMA --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                            data-label="Nama">
                                            {{ $teacher->name }}
                                        </td>

                                        {{-- EMAIL --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                            data-label="Email">
                                            {{ $teacher->email }}
                                        </td>

                                        {{-- GENDER --}}
                                        <td class="px-6 py-4 whitespace-nowrap" data-label="Gender">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $teacher->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                {{ $teacher->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                            </span>
                                        </td>

                                        {{-- SPESIALISASI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                            data-label="Spesialisasi">
                                            {{ $teacher->subject_specialization ?? '-' }}
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                            data-label="Aksi">

                                            {{-- DESKTOP --}}
                                            <div class="hidden sm:flex justify-center space-x-2">
                                                <a href="{{ route('admin.teachers.show', $teacher) }}"
                                                class="text-blue-600 hover:text-blue-900">Lihat</a>
                                                <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">Hapus</button>
                                                </form>
                                            </div>

                                            {{-- MOBILE --}}
                                            <div class="mobile-actions sm:hidden">
                                                <a href="{{ route('admin.teachers.show', $teacher) }}"
                                                class="text-blue-600 font-semibold">Lihat</a>
                                                <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                                class="text-indigo-600 font-semibold">Edit</a>
                                                <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}">
                                                    @csrf @method('DELETE')
                                                    <button class="text-red-600 font-semibold"
                                                            onclick="return confirm('Hapus data?')">Hapus</button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data guru ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($teachers->hasPages())
                        <div class="mt-6">
                            {{ $teachers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    {{-- </div> --}}
@endsection