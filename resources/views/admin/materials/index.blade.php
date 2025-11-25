@extends('layouts.app')

@section('title', 'Manajemen Materi Pelajaran')

@section('content')

    <div class="flex justify-between items-center mb-6">
        {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
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
                        window.location.href='{{ route('admin.materials.create') }}'; 
                    } 
                    endDrag();" @touchend.prevent="
                    if(!dragging){ 
                        window.location.href='{{ route('admin.materials.create') }}'; 
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
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
                <div class="mb-4 sm:mb-0">
                    <input type="text" placeholder="Cari materi..."
                        class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-64">
                </div>

                <div class="flex space-x-2">
                    <select class="border border-gray-300 rounded-lg px-4 py-2">
                        <option>Semua Mata Pelajaran</option>
                        <option>Matematika</option>
                        <option>Bahasa Indonesia</option>
                    </select>

                    <select class="border border-gray-300 rounded-lg px-4 py-2">
                        <option>Semua Guru</option>
                        <option>Ada Guru</option>
                        <option>Tanpa Guru</option>
                    </select>
                </div>
            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata
                                Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe
                                File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ukuran</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($materials as $material)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">

                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if(str_contains($material->file_type, 'image'))
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="{{ asset('storage/' . $material->file_path) }}" alt="">
                                            @elseif(str_contains($material->file_type, 'pdf'))
                                                <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                                    <span class="text-red-600 font-bold">PDF</span>
                                                </div>
                                            @elseif(str_contains($material->file_type, 'video'))
                                                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-blue-600 font-bold">VID</span>
                                                </div>
                                            @else
                                                <div class="h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                    <span class="text-gray-600 font-bold">DOC</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $material->title }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ Str::limit($material->description, 50) }}
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $material->subject->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $material->teacher->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $material->file_type }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ number_format(Storage::disk('public')->size($material->file_path) / 1024, 1) }} KB
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">

                                        <a href="{{ route('admin.materials.show', $material) }}"
                                            class="text-blue-600 hover:text-blue-900">Lihat</a>

                                        <a href="{{ route('admin.materials.edit', $material) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</a>

                                        <a href="{{ route('admin.materials.download', $material) }}"
                                            class="text-green-600 hover:text-green-900">Download</a>

                                        <form method="POST" action="{{ route('admin.materials.destroy', $material) }}"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data materi ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($materials->hasPages())
                <div class="mt-6">
                    {{ $materials->links() }}
                </div>
            @endif

        </div>

@endsection