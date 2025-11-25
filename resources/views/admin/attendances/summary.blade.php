@extends('layouts.app')

@section('title', 'Ringkasan Kehadiran Siswa')

@section('content')

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">

            <!-- Alpine sudah ada di layout (navbar + sidebar), jadi tidak perlu include lagi -->

            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Ringkasan Kehadiran Siswa
                </h2>
                <a href="{{ route('admin.attendances.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>

            <!-- Filter -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
                <div class="mb-4 sm:mb-0">
                    <form method="GET" action="{{ route('admin.attendances.summary') }}" class="flex space-x-2">
                        <select name="month" class="border border-gray-300 rounded-lg px-4 py-2">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>

                        <select name="year" class="border border-gray-300 rounded-lg px-4 py-2">
                            <option value="">Semua Tahun</option>
                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Filter
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabel Ringkasan -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                                Hari</th>
                            <th class="px-6 py-3">Hadir</th>
                            <th class="px-6 py-3">Tidak Hadir</th>
                            <th class="px-6 py-3">Terlambat</th>
                            <th class="px-6 py-3">Izin</th>
                            <th class="px-6 py-3">Persentase Hadir</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($summary as $studentSummary)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-bold text-blue-600 dark:text-blue-300">
                                                {{ substr($studentSummary['student']->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                                {{ $studentSummary['student']->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                NIS: {{ $studentSummary['student']->nis }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-gray-900 dark:text-gray-200">
                                    {{ $studentSummary['student']->class->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-gray-900 dark:text-gray-200">
                                    {{ $studentSummary['total'] }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $studentSummary['present'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ $studentSummary['absent'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $studentSummary['late'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $studentSummary['excused'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-green-600 h-2 rounded-full"
                                                style="width: {{ $studentSummary['present_percentage'] }}%"></div>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                                            {{ $studentSummary['present_percentage'] }}%
                                        </span>
                                    </div>
                                </td>

                                <!-- Tombol modal -->
                                <td class="px-6 py-4">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded view-chart-btn"
                                        data-student-name="{{ $studentSummary['student']->name }}"
                                        data-class-name="{{ $studentSummary['student']->class->name ?? '-' }}"
                                        data-present="{{ $studentSummary['present'] }}"
                                        data-absent="{{ $studentSummary['absent'] }}" data-late="{{ $studentSummary['late'] }}"
                                        data-excused="{{ $studentSummary['excused'] }}"
                                        data-total="{{ $studentSummary['total'] }}"
                                        data-percentage="{{ $studentSummary['present_percentage'] }}">
                                        Lihat
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data ringkasan kehadiran ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Chart (Alpine.js) -->
    <div x-data="{ open: false }" x-show="open" style="display: none" x-on:open-modal.window="open = true"
        x-on:close-modal.window="open = false" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" x-on:click="open = false"></div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full p-6 relative z-20">
            <h2 class="text-xl font-bold mb-1 text-gray-900 dark:text-gray-100">
                Grafik Kehadiran Siswa
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Ringkasan kehadiran berdasarkan kategori
            </p>

            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4 border border-gray-200 dark:border-gray-600">
                <p><strong>Nama:</strong> <span id="modal-student-name"></span></p>
                <p><strong>Kelas:</strong> <span id="modal-class-name"></span></p>
                <p><strong>Total Hari:</strong> <span id="modal-total-days"></span></p>
                <p><strong>Persentase Hadir:</strong> <span id="modal-present-percentage"></span>%</p>
            </div>

            <canvas id="attendanceChart" class="w-full h-52"></canvas>

            <div class="text-right mt-6">
                <button class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-800" x-on:click="open = false">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let chartInstance = null;

            document.querySelectorAll('.view-chart-btn').forEach(button => {
                button.addEventListener('click', function () {

                    const studentName = this.dataset.studentName;
                    const className = this.dataset.className;
                    const present = parseInt(this.dataset.present);
                    const absent = parseInt(this.dataset.absent);
                    const late = parseInt(this.dataset.late);
                    const excused = parseInt(this.dataset.excused);
                    const total = parseInt(this.dataset.total);
                    const percentage = parseFloat(this.dataset.percentage);

                    document.getElementById('modal-student-name').textContent = studentName;
                    document.getElementById('modal-class-name').textContent = className;
                    document.getElementById('modal-total-days').textContent = total;
                    document.getElementById('modal-present-percentage').textContent = percentage.toFixed(2);

                    if (chartInstance) chartInstance.destroy();

                    const ctx = document.getElementById('attendanceChart').getContext('2d');
                    chartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Hadir', 'Tidak Hadir', 'Terlambat', 'Izin'],
                            datasets: [{
                                label: 'Jumlah Hari',
                                data: [present, absent, late, excused],
                                backgroundColor: [
                                    'rgba(34, 197, 94, 0.8)',
                                    'rgba(239, 68, 68, 0.8)',
                                    'rgba(245, 158, 11, 0.8)',
                                    'rgba(59, 130, 246, 0.8)',
                                ],
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } }
                        }
                    });

                    window.dispatchEvent(new CustomEvent('open-modal'));
                });
            });
        });
    </script>

@endsection