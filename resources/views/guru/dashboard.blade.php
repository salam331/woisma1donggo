@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT : Motivasi dan Ringkasan Tugas -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Motivasi Mengajar -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Motivasi Mengajar Hari Ini
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg shadow">
                            <p class="text-gray-700 text-sm">“Guru yang baik menginspirasi siswa, bukan hanya mengajar.”</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg shadow">
                            <p class="text-gray-700 text-sm">“Setiap tantangan dalam mengajar adalah kesempatan untuk berkembang.”</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg shadow">
                            <p class="text-gray-700 text-sm">“Kesabaran adalah kunci untuk membimbing setiap siswa.”</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg shadow">
                            <p class="text-gray-700 text-sm">“Mengajar dengan hati membuat ilmu lebih bermakna.”</p>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Kelas & Tugas -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Ringkasan Kelas
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-500 text-white p-5 rounded-lg shadow text-center">
                            <h3 class="text-xl font-bold">{{ $classes_count ?? 0 }}</h3>
                            <p class="text-sm mt-1">Jumlah Kelas</p>
                        </div>
                        <div class="bg-green-500 text-white p-5 rounded-lg shadow text-center">
                            <h3 class="text-xl font-bold">{{ $exams_count ?? 0 }}</h3>
                            <p class="text-sm mt-1">Jumlah Ujian</p>
                        </div>
                        <div class="bg-purple-500 text-white p-5 rounded-lg shadow text-center">
                            <h3 class="text-xl font-bold">{{ $materials_uploaded ?? 0 }}</h3>
                            <p class="text-sm mt-1">Materi Diupload</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT : Jadwal Hari Ini & Tips Mengajar -->
            <div class="space-y-6">

                <!-- Jadwal Hari Ini -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-600 mb-4">
                        Jadwal Hari Ini
                    </h3>
                    @if(isset($today_schedule) && $today_schedule->isNotEmpty())
                        <ul class="space-y-2 text-gray-700 text-sm">
                            @foreach($today_schedule as $schedule)
                                <li class="flex justify-between items-center bg-gray-50 rounded-lg p-3">
                                    <span>{{ $schedule->subject->name }} <br> ({{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }})</span>
                                    <span class="text-xs text-gray-500">{{ $schedule->class->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-xs text-gray-500 text-center">Tidak ada jadwal hari ini</p>
                    @endif
                    <a href="{{ route('guru.schedules.index') }}" class="block text-center mt-2 text-xs text-blue-600 hover:underline">Lihat Semua Jadwal</a>
                </div>

                <!-- Statistik Kehadiran Kelas -->
                {{-- <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">
                        Statistik Kehadiran
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $stats['hadir'] ?? 0 }}</div>
                            <div class="text-xs text-gray-600">Hadir</div>
                        </div>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $stats['izin'] ?? 0 }}</div>
                            <div class="text-xs text-gray-600">Izin</div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $stats['terlambat'] ?? 0 }}</div>
                            <div class="text-xs text-gray-600">Terlambat</div>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-red-600">{{ $stats['tidak_hadir'] ?? 0 }}</div>
                            <div class="text-xs text-gray-600">Tidak Hadir</div>
                        </div>
                    </div>
                </div> --}}

                <!-- Tips Mengajar -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">
                        Tips Mengajar
                    </h3>
                    <ul class="space-y-2 text-xs text-gray-600 list-disc list-inside">
                        <li>Persiapkan materi dengan baik sebelum mengajar.</li>
                        <li>Libatkan siswa dengan pertanyaan dan diskusi aktif.</li>
                        <li>Berikan pujian dan umpan balik yang konstruktif.</li>
                        <li>Gunakan media dan metode berbeda untuk menjaga perhatian siswa.</li>
                        <li>Catat progres tiap siswa untuk evaluasi pembelajaran.</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
