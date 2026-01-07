@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT : Motivasi dan Tugas -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Motivasi Belajar -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Motivasi Belajar Hari Ini
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg shadow">
                            <p class="text-gray-700 text-sm">“Kesuksesan adalah hasil dari ketekunan, bukan keberuntungan.”</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg shadow">
                            <p class="text-gray-700 text-sm">“Setiap hari adalah kesempatan baru untuk belajar sesuatu yang luar biasa.”</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg shadow">
                            <p class="text-gray-700 text-sm">“Jangan takut gagal, karena setiap kesalahan adalah pelajaran berharga.”</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg shadow">
                            <p class="text-gray-700 text-sm">“Fokus dan konsisten adalah kunci meraih prestasi.”</p>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Tugas -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Ringkasan Tugas
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-500 text-white p-5 rounded-lg shadow text-center">
                            <h3 class="text-xl font-bold">{{ $tasks_today ?? 0 }}</h3>
                            <p class="text-sm mt-1">Tugas Hari Ini</p>
                        </div>
                        <div class="bg-green-500 text-white p-5 rounded-lg shadow text-center">
                            <h3 class="text-xl font-bold">{{ $materials ?? 0 }}</h3>
                            <p class="text-sm mt-1">Materi Belajar</p>
                        </div>
                        <div class="bg-yellow-500 text-white p-5 rounded-lg shadow text-center">
                            <h3 class="text-xl font-bold">{{ $average_score ?? 0 }}</h3>
                            <p class="text-sm mt-1">Nilai Rata-Rata</p>
                        </div>
                        <div class="bg-purple-500 text-white p-5 rounded-lg shadow text-center">
                            <h3 class="text-xl font-bold">{{ $completed_tasks ?? 0 }}</h3>
                            <p class="text-sm mt-1">Tugas Selesai</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT : Statistik Kehadiran & Motivasi -->
            <div class="space-y-6">
                <!-- Tips Belajar -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">
                        Tips Belajar
                    </h3>
                    <ul class="space-y-2 text-xs text-gray-600 list-disc list-inside">
                        <li>Buat jadwal belajar harian agar lebih teratur.</li>
                        <li>Fokus pada satu materi hingga benar-benar paham sebelum lanjut.</li>
                        <li>Istirahat sejenak setiap 45-60 menit belajar untuk menyegarkan otak.</li>
                        <li>Jangan ragu bertanya jika ada materi yang sulit dipahami.</li>
                        <li>Gunakan catatan dan mind map untuk mempermudah hafalan.</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
