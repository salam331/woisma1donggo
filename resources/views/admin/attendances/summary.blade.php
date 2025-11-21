<x-admin-layout>
    <!-- Bootstrap CSS for Modal -->
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
                    <!-- Modal Tailwind (Alpine.js) -->
                    <div 
                        x-data="{ open: false }" 
                        x-show="open" 
                        style="display: none"
                        x-on:open-modal.window="open = true"
                        x-on:close-modal.window="open = false"
                        class="fixed inset-0 z-50 flex items-center justify-center"
                    >
                        <!-- Background -->
                        <div 
                            class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                            x-on:click="open = false"
                        ></div>

                        <!-- Modal Box -->
                        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full p-6 relative z-20">

                            <!-- Title -->
                            <h2 class="text-xl font-bold mb-1">Grafik Kehadiran Siswa</h2>
                            <p class="text-sm text-gray-600 mb-4">Ringkasan kehadiran berdasarkan kategori</p>

                            <!-- Info Siswa -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-4 border">
                                <p><span class="font-semibold">Nama:</span> <span id="modal-student-name"></span></p>
                                <p><span class="font-semibold">Kelas:</span> <span id="modal-class-name"></span></p>
                                <p><span class="font-semibold">Total Hari:</span> <span id="modal-total-days"></span></p>
                                <p><span class="font-semibold">Persentase Hadir:</span> <span id="modal-present-percentage"></span>%</p>
                            </div>

                            <!-- Chart -->
                            <canvas id="attendanceChart" class="w-full h-52"></canvas>

                            <!-- Footer -->
                            <div class="text-right mt-6">
                                <button
                                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-800"
                                    x-on:click="open = false"
                                >
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- JavaScript for Chart -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        let chartInstance = null;

                        document.querySelectorAll('.view-chart-btn').forEach(button => {
                            button.addEventListener('click', function () {

                                const studentName = this.dataset.studentName;
                                const className   = this.dataset.className;
                                const present     = parseInt(this.dataset.present);
                                const absent      = parseInt(this.dataset.absent);
                                const late        = parseInt(this.dataset.late);
                                const excused     = parseInt(this.dataset.excused);
                                const total       = parseInt(this.dataset.total);
                                const percentage  = parseFloat(this.dataset.percentage);

                                // Set modal info
                                document.getElementById('modal-student-name').textContent  = studentName;
                                document.getElementById('modal-class-name').textContent    = className;
                                document.getElementById('modal-total-days').textContent    = total;
                                document.getElementById('modal-present-percentage').textContent = percentage.toFixed(2);

                                // Destroy old chart
                                if (chartInstance) chartInstance.destroy();

                                // Build new chart
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
                                            borderWidth: 0
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: { display: false }
                                        }
                                    }
                                });

                                // OPEN modal Tailwind / Alpine
                                window.dispatchEvent(new CustomEvent('open-modal'));
                            });
                        });
                    });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
