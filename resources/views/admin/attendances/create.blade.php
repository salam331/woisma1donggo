@extends('layouts.app')

@section('title', 'Tambah Data Kehadiran')

@section('content')

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Tambah Data Kehadiran Baru
            </h2>
            <a href="{{ route('admin.attendances.index') }}"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </div>
        <form method="POST" action="{{ route('admin.attendances.store') }}" id="attendanceForm">
            @csrf

            <!-- STEP 1: PILIH KELAS -->
            <div class="mb-6">
                <label for="class_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                    Pilih Kelas
                </label>

                <select id="class_id" name="class_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Kelas</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }} - {{ $class->grade_level }}
                        {{ $class->major ? '(' . $class->major . ')' : '' }}
                    </option>
                    @endforeach
                </select>

                @error('class_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- STEP 2: PILIH JADWAL -->
            <div class="mb-6" id="scheduleSection" style="display: none;">
                <label for="schedule_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                    Pilih Jadwal
                </label>

                <select id="schedule_id" name="schedule_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Jadwal</option>

                    @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}" data-class="{{ $schedule->class_id }}"
                        {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                        {{ $schedule->subject->name ?? '-' }} -
                        {{ $schedule->class->name ?? '-' }} -
                        {{ $schedule->day }} {{ $schedule->start_time }}
                    </option>
                    @endforeach
                </select>

                @error('schedule_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- STEP 3: PILIH TANGGAL -->
            <div class="mb-6" id="dateSection" style="display: none;">
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                    Tanggal Absensi
                </label>

                <input id="date" type="date" name="date" value="{{ old('date') }}" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                @error('date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- STUDENT TABLE -->
            <div id="studentList" style="display: none;">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Daftar Siswa Kelas
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    NIS
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nama Siswa
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status Kehadiran
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Catatan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
                               id="studentTableBody">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SUBMIT -->
            <div class="flex items-center justify-end mt-6" id="submitSection" style="display: none;">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan Kehadiran
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('class_id');
    const scheduleSelect = document.getElementById('schedule_id');
    const dateInput = document.getElementById('date');
    const scheduleSection = document.getElementById('scheduleSection');
    const dateSection = document.getElementById('dateSection');
    const studentList = document.getElementById('studentList');
    const submitSection = document.getElementById('submitSection');
    const studentTableBody = document.getElementById('studentTableBody');

    classSelect.addEventListener('change', function() {
        const selectedClassId = this.value;

        if (selectedClassId) {
            scheduleSection.style.display = 'block';

            const options = scheduleSelect.querySelectorAll('option');
            options.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                } else {
                    const classId = option.getAttribute('data-class');
                    option.style.display = classId === selectedClassId ? 'block' : 'none';
                }
            });

            scheduleSelect.value = '';
            dateInput.value = '';
            dateSection.style.display = 'none';
            studentList.style.display = 'none';
            submitSection.style.display = 'none';
        } else {
            scheduleSection.style.display = 'none';
            dateSection.style.display = 'none';
            studentList.style.display = 'none';
            submitSection.style.display = 'none';
        }
    });

    scheduleSelect.addEventListener('change', function() {
        if (this.value) {
            dateSection.style.display = 'block';
            dateInput.value = '';
            studentList.style.display = 'none';
            submitSection.style.display = 'none';
        } else {
            dateSection.style.display = 'none';
            studentList.style.display = 'none';
            submitSection.style.display = 'none';
        }
    });

    dateInput.addEventListener('change', function() {
        const classId = classSelect.value;
        const scheduleId = scheduleSelect.value;
        const date = this.value;

        if (classId && scheduleId && date) {
            loadStudents(classId);
            studentList.style.display = 'block';
            submitSection.style.display = 'block';
        }
    });

    function loadStudents(classId) {
        fetch(`/admin/classes/${classId}/students`)
            .then(response => response.json())
            .then(data => {
                studentTableBody.innerHTML = '';

                data.students.forEach(student => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">${student.nis}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">${student.name}</td>
                        <td class="px-6 py-4">
                            <select name="attendances[${student.id}][status]" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                                <option value="">Pilih Status</option>
                                <option value="present">Hadir</option>
                                <option value="absent">Tidak Hadir</option>
                                <option value="late">Terlambat</option>
                                <option value="excused">Izin</option>
                            </select>

                            <input type="hidden" name="attendances[${student.id}][student_id]" value="${student.id}">
                            <input type="hidden" name="attendances[${student.id}][schedule_id]" value="${scheduleSelect.value}">
                            <input type="hidden" name="attendances[${student.id}][date]" value="${dateInput.value}">
                        </td>

                        <td class="px-6 py-4">
                            <textarea name="attendances[${student.id}][notes]" rows="2"
                                class="mt-1 block w-full border-gray-300 rounded-md focus:ring-blue-500"
                                placeholder="Catatan (opsional)"></textarea>
                        </td>
                    `;

                    studentTableBody.appendChild(row);
                });
            });
    }
});
</script>
@endsection
