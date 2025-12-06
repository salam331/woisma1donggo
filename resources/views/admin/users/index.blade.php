@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<!-- Floating AssistiveTouch Button -->
<!-- Floating AssistiveTouch Button -->
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
    }"
     x-init="startIdleTimer()"
     @resize.window="if(!dragging && !isAnimating) { snapToEdge(); }"
     x-on:destroy.window="cleanup()"
     class="fixed z-50 select-none"
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
             }"

         @touchmove.prevent="let dx = $event.touches[0].clientX - startX; 
                  let dy = $event.touches[0].clientY - startY; 
                  if(Math.abs(dx) > clickThreshold || Math.abs(dy) > clickThreshold){ 
                      dragging = true; 
                      handleMove(dx, dy);
                      startX = $event.touches[0].clientX; 
                      startY = $event.touches[0].clientY; 
                  }"

         @mouseup.prevent="
            if(!dragging){ 
                window.location.href='{{ route('admin.users.create') }}'; 
            } 
            endDrag();"
            
         @touchend.prevent="
            if(!dragging){ 
                window.location.href='{{ route('admin.users.create') }}'; 
            } 
            endDrag();"

         @mouseleave="if(dragging) { endDrag(); }"

         :class="[
             hidden ? 'opacity-30' : 'opacity-100',
             dragging ? 'scale-105 bg-blue-600 shadow-xl' : 'scale-100',
             isAnimating ? 'pointer-events-none' : ''
         ]"
         class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white shadow-lg cursor-pointer hover:bg-blue-600 active:bg-blue-700 transition-all duration-200 transform-gpu touch-none">
        <span class="font-bold text-lg" :class="dragging || isAnimating ? 'scale-110' : 'scale-100'">+</span>
    </div>
</div>


<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
    <div class="p-2">
        <!-- Search & Filter -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
            <div class="mb-4 sm:mb-0">
                <input type="text"
                       placeholder="Cari pengguna..."
                       class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-64 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            </div>
            <div class="flex space-x-2">
                <select class="border border-gray-300 rounded-lg px-4 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option>Semua Role</option>
                    <option>Admin</option>
                    <option>Guru</option>
                    <option>Siswa</option>
                    <option>Orang Tua</option>
                </select>
            </div>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dibuat</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                @forelse($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                    <td data-label="Nama" class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                    {{ substr($user->name, 0, 1) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $user->name }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td data-label="Email" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                        {{ $user->email }}
                    </td>

                    <td data-label="Role" class="px-6 py-4 whitespace-nowrap">
                        @foreach($user->roles as $role)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                            text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100">
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </td>

                    <td data-label="Status" class="px-6 py-4 whitespace-nowrap">
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($user->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Tidak Aktif
                            </span>
                            @endif
                        </dd>
                    </td>

                    <td data-label="Dibuat" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>

                    <td data-label="Aksi" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                        <!-- DESKTOP -->
                        <div class="hidden sm:flex justify-center space-x-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900">Lihat</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Edit</a>

                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 dark:text-red-400 hover:text-red-900">
                                    Hapus
                                </button>
                            </form>
                        </div>

                        <!-- MOBILE -->
                        <div class="mobile-actions sm:hidden">
                            <a href="{{ route('admin.users.show', $user) }}" class="px-3 py-1 text-xs rounded bg-blue-500 text-white">View</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1 text-xs rounded bg-indigo-500 text-white">Edit</a>

                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 text-xs rounded bg-red-500 text-white">
                                    Delete
                                </button>
                            </form>
                        </div>

                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                        Tidak ada pengguna ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>

            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
