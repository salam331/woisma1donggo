@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
<div class="py-6 space-y-8">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
            Dashboard Admin
        </h2>
        <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ now()->format('l, d F Y') }}
        </span>
    </div>

    {{-- STATISTICS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        @php
            $cards = [
                ['label'=>'Siswa','count'=>\App\Models\Student::count(),'color'=>'blue'],
                ['label'=>'Guru','count'=>\App\Models\Teacher::count(),'color'=>'green'],
                ['label'=>'Kelas','count'=>\App\Models\SchoolClass::count(),'color'=>'yellow'],
                ['label'=>'Materi','count'=>\App\Models\Material::count(),'color'=>'purple'],
            ];
        @endphp

        @foreach ($cards as $card)
        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow hover:shadow-lg transition">
            <div class="absolute right-0 top-0 h-24 w-24 bg-{{ $card['color'] }}-500/10 rounded-bl-full"></div>

            <div class="p-6 relative z-10">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Total {{ $card['label'] }}
                </p>
                <p class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">
                    {{ $card['count'] }}
                </p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- GRAFIK --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Grafik Bar --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                Distribusi Data Sekolah
            </h3>
            <canvas id="barChart"></canvas>
        </div>

        {{-- Grafik Donut --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                Komposisi Entitas
            </h3>
            <canvas id="donutChart"></canvas>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-5">
                Aksi Cepat
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $actions = [
                        ['label'=>'Tambah Siswa','route'=>'admin.students.create','color'=>'blue'],
                        ['label'=>'Tambah Guru','route'=>'admin.teachers.create','color'=>'green'],
                        ['label'=>'Tambah Kelas','route'=>'admin.classes.create','color'=>'yellow'],
                        ['label'=>'Tambah Mapel','route'=>'admin.subjects.create','color'=>'purple'],
                        ['label'=>'Tambah Orang Tua','route'=>'admin.parents.create','color'=>'indigo'],
                        ['label'=>'Tambah Pengguna','route'=>'admin.users.create','color'=>'red'],
                    ];
                @endphp

                @foreach ($actions as $action)
                <a href="{{ route($action['route']) }}"
                   class="group flex items-center justify-between p-4 rounded-lg bg-{{ $action['color'] }}-50 dark:bg-{{ $action['color'] }}-900/20 hover:scale-[1.02] transition">
                    <span class="font-medium text-{{ $action['color'] }}-700 dark:text-{{ $action['color'] }}-300">
                        {{ $action['label'] }}
                    </span>
                    <span class="text-{{ $action['color'] }}-500 group-hover:translate-x-1 transition">→</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- SCRIPT CHART --}}
<script>
    const barCtx = document.getElementById('barChart');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Siswa', 'Guru', 'Kelas', 'Materi'],
            datasets: [{
                data: [
                    {{ \App\Models\Student::count() }},
                    {{ \App\Models\Teacher::count() }},
                    {{ \App\Models\SchoolClass::count() }},
                    {{ \App\Models\Material::count() }}
                ],
                backgroundColor: ['#3b82f6','#22c55e','#eab308','#a855f7']
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            responsive: true
        }
    });

    const donutCtx = document.getElementById('donutChart');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Siswa','Guru','Kelas','Materi'],
            datasets: [{
                data: [
                    {{ \App\Models\Student::count() }},
                    {{ \App\Models\Teacher::count() }},
                    {{ \App\Models\SchoolClass::count() }},
                    {{ \App\Models\Material::count() }}
                ],
                backgroundColor: ['#60a5fa','#4ade80','#fde047','#c084fc']
            }]
        }
    });
</script>
@endsection
