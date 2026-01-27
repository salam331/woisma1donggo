@extends('layouts.app')

@section('title', 'Manajemen Materi Pelajaran')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
    {{-- @include('components.sidebar-admin') --}}

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content -->
        <div x-data="{...floatingBtnConfig(), 
                    idleDelay: 2000,
                    startIdleTimer() {
                        clearTimeout(this.idleTimer);
                        this.idleTimer = setTimeout(() => {
                            if (!this.dragging && !this.isAnimating) {
                                this.snapToEdge();
                            }
                        }, this.idleDelay);
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

        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                {{-- Session alerts removed - now using toast notifications --}}

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border dark:border-gray-700 p-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-0">
                            <i class="fas fa-book-open mr-2 text-blue-600"></i>
                            Manajemen Materi Pelajaran
                        </h2>
                        
                        <a href="{{ route('admin.materials.create') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Materi
                        </a>
                    </div>

                    <!-- Search & Filter -->
                    <form method="GET" action="{{ route('admin.materials.index') }}"
                        class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">

                        {{-- SEARCH --}}
                        <div class="w-full sm:w-64">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari materi..."
                                {{-- oninput="this.form.submit()" --}}
                                class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                    dark:text-white rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="flex space-x-2 w-full sm:w-auto">

                            {{-- FILTER MAPEL --}}
                            <select
                                name="subject_id"
                                onchange="this.form.submit()"
                                class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                    dark:text-white rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Mata Pelajaran</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- FILTER KELAS --}}
                            <select
                                name="class_id"
                                onchange="this.form.submit()"
                                class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                    dark:text-white rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </form>

                    <!-- TABLE -->
                    @if($materials->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Judul
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Mata Pelajaran
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Guru
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Kelas
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Ukuran
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($materials as $material)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            {{-- JUDUL --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($material->mime_type && str_starts_with($material->mime_type, 'image/'))
                                                            <img class="h-10 w-10 rounded-full object-cover"
                                                                src="{{ asset('storage/' . $material->file_path) }}" alt="">
                                                        @elseif($material->mime_type === 'application/pdf')
                                                            <div class="h-10 w-10 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                                                                <span class="text-red-600 dark:text-red-400 font-bold text-xs">PDF</span>
                                                            </div>
                                                        @elseif(str_contains($material->mime_type, 'video'))
                                                            <div class="h-10 w-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                                                <span class="text-blue-600 dark:text-blue-400 font-bold text-xs">VID</span>
                                                            </div>
                                                        @else
                                                            <div class="h-10 w-10 bg-gray-100 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                                                <span class="text-gray-600 dark:text-gray-300 font-bold text-xs">DOC</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $material->title }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ Str::limit($material->description, 30) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- SUBJECT --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $material->subject->name ?? '-' }}
                                            </td>

                                            {{-- TEACHER --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $material->teacher->name ?? '-' }}
                                            </td>

                                            {{-- CLASS --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $material->class->name ?? '-' }}
                                            </td>

                                            {{-- STATUS --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($material->is_public)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                        <i class="fas fa-eye mr-1"></i>Publik
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                        <i class="fas fa-lock mr-1"></i>Private
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- FILE SIZE --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $material->file_size ? number_format($material->file_size / 1024, 1) . ' KB' : '-' }}
                                            </td>

                                            {{-- ACTIONS --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-x-2">
                                                    {{-- Tombol Lihat --}}
                                                    <a href="{{ route('admin.materials.show', $material) }}"
                                                        class="p-2 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300 dark:hover:bg-blue-800 transition-colors duration-200"
                                                        title="Lihat">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    </a>

                                                    {{-- Tombol Edit --}}
                                                    <a href="{{ route('admin.materials.edit', $material) }}"
                                                        class="p-2 rounded-full bg-yellow-100 text-yellow-700 hover:bg-yellow-200 dark:bg-yellow-900 dark:text-yellow-300 dark:hover:bg-yellow-800 transition-colors duration-200"
                                                        title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>
                                                    </a>

                                                    {{-- Tombol Download --}}
                                                    <a href="{{ route('admin.materials.download', $material) }}"
                                                        class="p-2 rounded-full bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900 dark:text-green-300 dark:hover:bg-green-800 transition-colors duration-200"
                                                        title="Download">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                        </svg>
                                                    </a>

                                                    {{-- Tombol Hapus --}}
                                                    <form method="POST" action="{{ route('admin.materials.destroy', $material) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')"
                                                            class="p-2 rounded-full bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900 dark:text-red-300 dark:hover:bg-red-800 transition-colors duration-200"
                                                            title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
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
                            {{ $materials->links() }}
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div class="mb-6">
                                <i class="fas fa-folder-open text-6xl text-gray-300 dark:text-gray-600"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                Belum Ada Materi
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md">
                                Anda belum mengunggah materi pembelajaran. Mulai dengan mengunggah materi pertama Anda.
                            </p>
                            <a href="{{ route('admin.materials.create') }}"
                               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                                <i class="fas fa-plus"></i>
                                Tambah Materi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    // Floating button configuration
    function floatingBtnConfig() {
        return {
            posX: window.innerWidth - 70,
            posY: window.innerHeight / 2,
            dragging: false,
            startX: 0,
            startY: 0,
            clickThreshold: 5,
            idleTimer: null,
            screenPadding: 10,
            hidden: false,
            animationFrame: null,
            isAnimating: false,

            startIdleTimer() {
                clearTimeout(this.idleTimer);
                this.idleTimer = setTimeout(() => {
                    if (!this.dragging && !this.isAnimating) {
                        this.snapToEdge();
                    }
                }, this.idleDelay || 1500);
            },

            snapToEdge() {
                if (this.dragging || this.isAnimating) return;

                const screenWidth = window.innerWidth;
                const screenHeight = window.innerHeight;

                this.cancelAnimation();

                let targetX, targetY = this.posY;

                if (this.posX < screenWidth / 2) {
                    targetX = this.screenPadding;
                } else {
                    targetX = screenWidth - 60 - this.screenPadding;
                }

                targetY = Math.min(
                    Math.max(this.screenPadding, targetY),
                    screenHeight - 60 - this.screenPadding
                );

                if (Math.abs(this.posX - targetX) > 5) {
                    this.animateToPosition(targetX, targetY);
                }
            },

            animateToPosition(targetX, targetY) {
                this.isAnimating = true;
                const startX = this.posX;
                const startY = this.posY;
                const duration = 400;
                const startTime = performance.now();

                const animate = (currentTime) => {
                    if (this.dragging) {
                        this.cancelAnimation();
                        this.isAnimating = false;
                        return;
                    }

                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
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
        };
    }
</script>
@endsection

