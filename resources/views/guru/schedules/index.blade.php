@extends('layouts.app')

@section('title', 'Jadwal Pelajaran - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">

    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Jadwal Mengajar</h2>

                    @if($schedules->count() > 0)
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($schedules->groupBy('day') as $day => $daySchedules) 
                            @php
                                $isToday = strtolower($day) === strtolower(now()->format('l'));
                            @endphp
                            <div class="border {{ $isToday ? 'border-blue-500 ring-1 ring-blue-500 dark:border-blue-400 dark:ring-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'dark:border-gray-600' }} rounded-lg p-4 relative">
                                @if($isToday)
                                    <div class="absolute top-4 right-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                            Hari Ini
                                        </span>
                                    </div>
                                @endif
                                <h3 class="font-semibold text-lg {{ $isToday ? 'text-blue-700 dark:text-blue-300' : 'text-gray-900 dark:text-white' }} mb-4 capitalize">
                                    {{ $day }}
                                </h3>
                                <div class="space-y-3">
                                    @foreach($daySchedules as $schedule)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded p-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-medium text-gray-900 dark:text-white">
                                                {{ $schedule->subject->name }}
                                            </h4>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            Kelas: {{ $schedule->class->name }}
                                        </p>
                                        <div class="mt-2">
                                            <a href="{{ route('guru.schedules.show', $schedule) }}"
                                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-calendar text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada jadwal</h3>
                            <p class="text-gray-500 dark:text-gray-400">Anda belum memiliki jadwal mengajar yang terjadwal.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
