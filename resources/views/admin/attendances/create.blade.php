<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Data Kehadiran Baru
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
                    <form method="POST" action="{{ route('admin.attendances.store') }}" id="attendanceForm">
                        @csrf

                        <!-- Step 1: Select Kelas -->
                        <div class="mb-6">
                            <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Kelas</label>
                            <select id="class_id" name="class_id" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }} - {{ $class->grade_level }} {{ $class->major ? '(' . $class->major . ')' : '' }}
                                </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 2: Select Jadwal -->
                        <div class="mb-6" id="scheduleSection" style="display: none;">
                            <label for="schedule_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Jadwal</label>
                            <select id="schedule_id" name="schedule_id" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Jadwal</option>
                                @foreach($schedules as $schedule)
                                <option value="{{ $schedule->id }}" data-class="{{ $schedule->class_id }}" {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                    {{ $schedule->subject->name ?? '-' }} - {{ $schedule->class->name ?? '-' }} - {{ $schedule->day }} {{ $schedule->start_time }}
                                </option>
                                @endforeach
                            </select>
                            @error('schedule_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 3: Tanggal Absensi -->
                        <div class="mb-6" id="dateSection" style="display: none;">
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Absensi</label>
                            <input id="date" type="date" name="date" value="{{ old('date') }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Student Attendance List -->
                        <div id="studentList" style="display: none;">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Siswa Kelas</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                NIS
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Siswa
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status Kehadiran
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Catatan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="studentTableBody">
                                        <!-- Students will be loaded here via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6" id="submitSection" style="display: none;">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Kehadiran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

            // Step 1: When class is selected, show schedule section and filter schedules
            classSelect.addEventListener('change', function() {
                const selectedClassId = this.value;
                if (selectedClassId) {
                    scheduleSection.style.display = 'block';
                    // Filter schedules based on selected class
                    const options = scheduleSelect.querySelectorAll('option');
                    options.forEach(option => {
                        if (option.value === '') {
                            option.style.display = 'block';
                        } else {
                            const classId = option.getAttribute('data-class');
                            option.style.display = classId === selectedClassId ? 'block' : 'none';
                        }
                    });
                    // Reset subsequent fields
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

            // Step 2: When schedule is selected, show date section
            scheduleSelect.addEventListener('change', function() {
                if (this.value) {
                    dateSection.style.display = 'block';
                    // Reset subsequent fields
                    dateInput.value = '';
                    studentList.style.display = 'none';
                    submitSection.style.display = 'none';
                } else {
                    dateSection.style.display = 'none';
                    studentList.style.display = 'none';
                    submitSection.style.display = 'none';
                }
            });

            // Step 3: When date is selected, load students and show attendance form
            dateInput.addEventListener('change', function() {
                const selectedClassId = classSelect.value;
                const selectedScheduleId = scheduleSelect.value;
                const selectedDate = this.value;

                if (selectedClassId && selectedScheduleId && selectedDate) {
                    loadStudents(selectedClassId);
                    studentList.style.display = 'block';
                    submitSection.style.display = 'block';
                } else {
                    studentList.style.display = 'none';
                    submitSection.style.display = 'none';
                }
            });

            function loadStudents(classId) {
                // Fetch students for the selected class
                fetch(`/admin/classes/${classId}/students`)
                    .then(response => response.json())
                    .then(data => {
                        studentTableBody.innerHTML = '';
                        data.students.forEach(student => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ${student.nis}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${student.name}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select name="attendances[${student.id}][status]" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Status</option>
                                        <option value="present">Hadir</option>
                                        <option value="absent">Tidak Hadir</option>
                                        <option value="late">Terlambat</option>
                                        <option value="excused">Izin</option>
                                    </select>
                                    <input type="hidden" name="attendances[${student.id}][student_id]" value="${student.id}">
                                    <input type="hidden" name="attendances[${student.id}][schedule_id]" value="${document.getElementById('schedule_id').value}">
                                    <input type="hidden" name="attendances[${student.id}][date]" value="${document.getElementById('date').value}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <textarea name="attendances[${student.id}][notes]" rows="2"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Catatan (opsional)"></textarea>
                                </td>
                            `;
                            studentTableBody.appendChild(row);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading students:', error);
                        alert('Terjadi kesalahan saat memuat data siswa.');
                    });
            }
        });
    </script>
</x-admin-layout>
