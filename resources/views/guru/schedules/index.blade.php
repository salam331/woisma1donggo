@extends('layouts.app')

@section('title', 'Jadwal Pelajaran - Guru Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800 p-6">

    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Jadwal Mengajar
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Ringkasan jadwal mengajar berdasarkan hari
                </p>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg ring-1 ring-black/5 dark:ring-white/10 p-8">

            @if($schedules->count() > 0)

                @php
                    $hariIndo = [
                        'monday'    => 'Senin',
                        'tuesday'   => 'Selasa',
                        'wednesday' => 'Rabu',
                        'thursday'  => 'Kamis',
                        'friday'    => 'Jumat',
                        'saturday'  => 'Sabtu',
                        'sunday'    => 'Minggu',
                    ];
                @endphp

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                    @foreach($schedules->groupBy('day') as $day => $daySchedules)
                        @php
                            $today = strtolower(now()->format('l'));
                            $isToday = strtolower($day) === $today;
                        @endphp

                        <!-- Day Card -->
                        <div class="relative rounded-xl border p-5 transition
                            {{ $isToday
                                ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 ring-2 ring-blue-400'
                                : 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800'
                            }}">

                            <!-- Badge Hari Ini -->
                            @if($isToday)
                                <span class="absolute top-4 right-4 text-xs font-semibold px-3 py-1 rounded-full
                                    bg-blue-600 text-white shadow">
                                    Hari Ini
                                </span>
                            @endif

                            <!-- Day Title -->
                            <h3 class="text-xl font-bold mb-4
                                {{ $isToday ? 'text-blue-700 dark:text-blue-300' : 'text-gray-900 dark:text-white' }}">
                                {{ $hariIndo[strtolower($day)] ?? ucfirst($day) }}
                            </h3>

                            <!-- Schedule List -->
                            <div class="space-y-4">

                                @foreach($daySchedules as $schedule)
                                    <div class="rounded-lg bg-white dark:bg-gray-700 p-4 shadow-sm hover:shadow transition">

                                        <div class="flex items-start justify-between mb-1">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                                {{ $schedule->subject->name }}
                                            </h4>
                                            <span class="text-xs font-medium px-2 py-1 rounded bg-gray-100 dark:bg-gray-600
                                                text-gray-600 dark:text-gray-300">
                                                {{ $schedule->start_time->format('H:i') }} – {{ $schedule->end_time->format('H:i') }}
                                            </span>
                                        </div>

                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                                            Kelas {{ $schedule->class->name }}
                                        </p>

                                        <a href="{{ route('guru.schedules.show', $schedule) }}"
                                           class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600
                                           hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition">
                                            <i class="fas fa-eye"></i>
                                            Lihat Detail
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full
                        bg-gray-100 dark:bg-gray-700 mb-6">
                        <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        Belum Ada Jadwal
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                        Jadwal mengajar belum tersedia. Silakan tambahkan jadwal agar dapat dikelola dengan baik.
                    </p>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection
