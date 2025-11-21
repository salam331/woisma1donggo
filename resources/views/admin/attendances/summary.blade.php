<x-admin-layout>
    <!-- Bootstrap CSS for Modal -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ringkasan Kehadiran Siswa
            </h2>
            <a href="{{ route('admin.attendances.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Filters -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <form method="GET" action="{{ route('admin.attendances.summary') }}" class="flex space-x-2">
                                <select name="month" class="border border-gray-300 rounded-lg px-4 py-2">
                                    <option value="">Semua Bulan</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                                </select>
                                <select name="year" class="border border-gray-300 rounded-lg px-4 py-2">
                                    <option value="">Semua Tahun</option>
                                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                        <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Filter
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Summary Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Hari</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tidak Hadir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terlambat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Izin</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase Hadir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($summary as $studentSummary)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-blue-600">{{ substr($studentSummary['student']->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $studentSummary['student']->name }}</div>
                                                <div class="text-sm text-gray-500">NIS: {{ $studentSummary['student']->nis }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $studentSummary['student']->class->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $studentSummary['total'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $studentSummary['present'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $studentSummary['absent'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            {{ $studentSummary['late'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $studentSummary['excused'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $studentSummary['present_percentage'] }}%"></div>
                                            </div>
                                            <span class="ml-2 text-sm font-medium">{{ $studentSummary['present_percentage'] }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded view-chart-btn"
                                                data-student-name="{{ $studentSummary['student']->name }}"
                                                data-class-name="{{ $studentSummary['student']->class->name ?? '-' }}"
                                                data-present="{{ $studentSummary['present'] }}"
                                                data-absent="{{ $studentSummary['absent'] }}"
                                                data-late="{{ $studentSummary['late'] }}"
                                                data-excused="{{ $studentSummary['excused'] }}"
                                                data-total="{{ $studentSummary['total'] }}"
                                                data-percentage="{{ $studentSummary['present_percentage'] }}">
                                            Lihat
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data ringkasan kehadiran ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal for Chart -->
                    <div class="modal fade" id="attendanceChartModal" tabindex="-1" role="dialog" aria-labelledby="attendanceChartModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="attendanceChartModalLabel">Grafik Kehadiran Siswa</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-4">
                                        <h6 class="font-weight-bold">Nama Siswa: <span id="modal-student-name"></span></h6>
                                        <p class="mb-1">Kelas: <span id="modal-class-name"></span></p>
                                        <p class="mb-1">Total Hari: <span id="modal-total-days"></span></p>
                                        <p class="mb-3">Persentase Hadir: <span id="modal-present-percentage"></span>%</p>
                                    </div>
                                    <canvas id="attendanceChart" width="400" height="200"></canvas>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- JavaScript for Chart -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let chartInstance = null;

                            document.querySelectorAll('.view-chart-btn').forEach(button => {
                                button.addEventListener('click', function() {
                                    const studentName = this.getAttribute('data-student-name');
                                    const className = this.getAttribute('data-class-name');
                                    const present = parseInt(this.getAttribute('data-present'));
                                    const absent = parseInt(this.getAttribute('data-absent'));
                                    const late = parseInt(this.getAttribute('data-late'));
                                    const excused = parseInt(this.getAttribute('data-excused'));
                                    const total = parseInt(this.getAttribute('data-total'));
                                    const percentage = parseFloat(this.getAttribute('data-percentage'));

                                    // Update modal content
                                    document.getElementById('modal-student-name').textContent = studentName;
                                    document.getElementById('modal-class-name').textContent = className;
                                    document.getElementById('modal-total-days').textContent = total;
                                    document.getElementById('modal-present-percentage').textContent = percentage.toFixed(2);

                                    // Destroy previous chart if exists
                                    if (chartInstance) {
                                        chartInstance.destroy();
                                    }

                                    // Create new chart
                                    const ctx = document.getElementById('attendanceChart').getContext('2d');
                                    chartInstance = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: ['Hadir', 'Tidak Hadir', 'Terlambat', 'Izin'],
                                            datasets: [{
                                                label: 'Jumlah Hari',
                                                data: [present, absent, late, excused],
                                                backgroundColor: [
                                                    'rgba(34, 197, 94, 0.8)', // Green for present
                                                    'rgba(239, 68, 68, 0.8)', // Red for absent
                                                    'rgba(245, 158, 11, 0.8)', // Yellow for late
                                                    'rgba(59, 130, 246, 0.8)' // Blue for excused
                                                ],
                                                borderColor: [
                                                    'rgba(34, 197, 94, 1)',
                                                    'rgba(239, 68, 68, 1)',
                                                    'rgba(245, 158, 11, 1)',
                                                    'rgba(59, 130, 246, 1)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                legend: {
                                                    display: false
                                                },
                                                tooltip: {
                                                    callbacks: {
                                                        label: function(context) {
                                                            return context.label + ': ' + context.parsed.y + ' hari';
                                                        }
                                                    }
                                                }
                                            },
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        stepSize: 1
                                                    }
                                                }
                                            }
                                        }
                                    });

                                    // Show modal
                                    $('#attendanceChartModal').modal('show');
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
