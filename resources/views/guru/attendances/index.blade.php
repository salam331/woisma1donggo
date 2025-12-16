@extends('layouts.app')

@section('title', 'Rekap Kehadiran Siswa - Kelas yang Anda Ajar')

@section('content')

    <div>
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
                        window.location.href='{{ route('guru.attendances.create') }}'; 
                    } 
                    endDrag();" @touchend.prevent="
                    if(!dragging){ 
                        window.location.href='{{ route('guru.attendances.create') }}'; 
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

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                        Rekap Kehadiran Siswa - Kelas yang Anda Ajar
                    </h2>

                    <div class="flex space-x-2">
                        <a href="{{ route('guru.attendances.summary') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Lihat Ringkasan
                        </a>
                    </div>
                </div>

                <!-- Filter Kelas -->
                @if($teacherClasses->count() > 0)
                <div class="mb-6">
                    <form method="GET" class="flex items-center space-x-4">
                        <label for="class_id" class="text-sm font-medium text-gray-700 dark:text-gray-200">Filter Kelas:</label>
                        <select name="class_id" id="class_id" onchange="this.form.submit()"
                                class="mt-1 block border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Semua Kelas yang Anda Ajar</option>
                            @foreach($teacherClasses as $class)
                            <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} - {{ $class->grade_level }} {{ $class->major ? '(' . $class->major . ')' : '' }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                @endif

                <!-- Classes Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-responsive">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Kelas yang Anda Ajar
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Total Kehadiran
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Hadir
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Tidak Hadir
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Terlambat
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Izin
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Persentase Hadir
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($teacherClasses as $class)
                                @php
                                    $totalAttendances = \App\Models\Attendance::whereHas('schedule', function ($q) use ($class) {
                                        $q->where('class_id', $class->id);
                                    })->count();

                                    $presentCount = \App\Models\Attendance::whereHas('schedule', function ($q) use ($class) {
                                        $q->where('class_id', $class->id);
                                    })->where('status', 'present')->count();

                                    $absentCount = \App\Models\Attendance::whereHas('schedule', function ($q) use ($class) {
                                        $q->where('class_id', $class->id);
                                    })->where('status', 'absent')->count();

                                    $lateCount = \App\Models\Attendance::whereHas('schedule', function ($q) use ($class) {
                                        $q->where('class_id', $class->id);
                                    })->where('status', 'late')->count();

                                    $excusedCount = \App\Models\Attendance::whereHas('schedule', function ($q) use ($class) {
                                        $q->where('class_id', $class->id);
                                    })->where('status', 'excused')->count();

                                    $presentPercentage = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100, 2) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td data-label="Kelas yang Anda Ajar"
                                        class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $class->name }} - {{ $class->grade_level }} {{ $class->major ? '(' . $class->major . ')' : '' }}
                                    </td>

                                    <td data-label="Total Kehadiran" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $totalAttendances }}
                                    </td>

                                    <td data-label="Hadir" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $presentCount }}
                                    </td>

                                    <td data-label="Tidak Hadir" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $absentCount }}
                                    </td>

                                    <td data-label="Terlambat" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $lateCount }}
                                    </td>

                                    <td data-label="Izin" class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $excusedCount }}
                                    </td>

                                    <td data-label="Persentase Hadir"
                                        class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $presentPercentage }}%
                                    </td>

                                    <td data-label="Aksi" class="px-6 py-4 text-center text-sm font-medium">
                                        <!-- DESKTOP -->
                                        <div class="flex items-center justify-center gap-x-4">
                                            <a href="{{ route('guru.attendances.index-by-class', $class->id) }}"
                                            class="p-2 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 hover:text-blue-900 transition-colors duration-200 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            </a>
                                        </div>

                                        <!-- MOBILE -->
                                        {{-- <div class="mobile-actions sm:hidden">
                                            <a href="{{ route('guru.attendances.index-by-class', $class->id) }}"
                                                class="px-3 py-1 text-xs rounded bg-blue-500 text-white">Lihat</a>
                                        </div> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                        Anda belum memiliki jadwal mengajar atau belum ada data kehadiran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Today's Schedule -->
                @if($todaySchedules->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Jadwal Hari Ini</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        Mata Pelajaran
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        Kelas
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        Waktu
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($todaySchedules as $schedule)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $schedule->subject->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $schedule->class->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                        {{ $schedule->day }} <br> {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

            </div>
        </div>

@endsection
