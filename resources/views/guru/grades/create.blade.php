@extends('layouts.app')

@section('title', 'Tambah Nilai Siswa - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                <div class="mb-6">
                    <a href="{{ route('guru.grades.index') }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Nilai
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                    <form id="grades-create-form" method="POST" action="{{ route('guru.grades.update-exam', [$classes->first()->id ?? 0, 0, 0]) }}">
                        @csrf
                        @method('PUT')

                        {{-- Kelas (pilihan dibatasi kelas guru) --}}
                        <div class="mb-4">
                            <label for="class_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Kelas <span class="text-red-500">*</span>
                            </label>
                            <select name="class_id" id="class_id" required
                                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Mata Pelajaran --}}
                        <div class="mb-4">
                            <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <select name="subject_id" id="subject_id" required
                                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Pilih Mata Pelajaran</option>
                            </select>
                        </div>

                        {{-- Ujian --}}
                        <div class="mb-4">
                            <label for="exam_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Ujian <span class="text-red-500">*</span>
                            </label>
                            <select name="exam_id" id="exam_id" required
                                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Pilih Ujian</option>
                            </select>
                        </div>

                        <hr class="my-6">

                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            Input Nilai Siswa
                        </h2>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nama Siswa
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            NIS
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nilai Angka
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Grade
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Catatan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="students-table-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                    {{-- row di-generate via AJAX --}}
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <a href="{{ route('guru.grades.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                Batal
                            </a>

                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                Simpan Nilai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('grades-create-form');
        const classSelect = document.getElementById('class_id');
        const subjectSelect = document.getElementById('subject_id');
        const examSelect = document.getElementById('exam_id');
        const studentsTableBody = document.getElementById('students-table-body');

        function resetSelect(selectElement, label) {
            selectElement.innerHTML = `<option value="">Pilih ${label}</option>`;
        }

        function updateActionUrl() {
            const classId = classSelect.value;
            const subjectId = subjectSelect.value;
            const examId = examSelect.value;

            // update action untuk route update-exam: /guru/grades/class/{classId}/subject/{subjectId}/exam/{examId}/update
            if (classId && subjectId && examId) {
                form.setAttribute('action', `/guru/grades/class/${classId}/subject/${subjectId}/exam/${examId}/update`);
            }
        }

        classSelect.addEventListener('change', function() {
            const classId = this.value;
            resetSelect(subjectSelect, 'Mata Pelajaran');
            resetSelect(examSelect, 'Ujian');
            studentsTableBody.innerHTML = '';

            if (classId) {
                loadSubjects(classId);
                loadStudents(classId);
            }

            updateActionUrl();
        });

        subjectSelect.addEventListener('change', function() {
            const classId = classSelect.value;
            const subjectId = this.value;

            resetSelect(examSelect, 'Ujian');
            studentsTableBody.innerHTML = '';

            if (classId && subjectId) {
                loadExams(classId, subjectId);
                loadStudents(classId);
            }

            updateActionUrl();
        });

        examSelect.addEventListener('change', function() {
            updateActionUrl();
        });

        function loadSubjects(classId) {
            fetch(`/guru/grades/get-subjects/${classId}`)
                .then(res => res.json())
                .then(data => {
                    resetSelect(subjectSelect, 'Mata Pelajaran');
                    data.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = subject.name;
                        subjectSelect.appendChild(option);
                    });
                })
                .catch(err => console.error('Error loading subjects:', err));
        }

        function loadExams(classId, subjectId) {
            fetch(`/guru/grades/get-exams/${classId}/${subjectId}`)
                .then(res => res.json())
                .then(data => {
                    resetSelect(examSelect, 'Ujian');
                    data.forEach(exam => {
                        const option = document.createElement('option');
                        option.value = exam.id;
                        option.textContent = exam.name;
                        examSelect.appendChild(option);
                    });
                })
                .catch(err => console.error('Error loading exams:', err));
        }

        function loadStudents(classId) {
            fetch(`/guru/grades/get-students/${classId}`)
                .then(res => res.json())
                .then(data => {
                    studentsTableBody.innerHTML = '';
                    data.forEach((student) => {
                        const row = document.createElement('tr');
                        row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                <div class="text-sm font-medium">${student.name}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                ${student.nis ?? 'N/A'}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number"
                                    name="grades[${student.id}][score]"
                                    min="0" max="100" step="0.01"
                                    class="w-24 px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="0"
                                    oninput="updateGradeLetter(${student.id})">
                                <input type="hidden" name="grades[${student.id}][student_id]" value="${student.id}">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span id="grade-${student.id}"
                                      class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">-</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <textarea name="grades[${student.id}][notes]"
                                    rows="1"
                                    class="w-72 max-w-xs border border-gray-300 rounded-md px-2 py-1 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                            </td>
                        `;
                        studentsTableBody.appendChild(row);
                    });
                })
                .catch(err => console.error('Error loading students:', err));
        }

        // expose for inline oninput
        window.updateGradeLetter = function(studentId) {
            const scoreInput = document.querySelector(`input[name="grades[${studentId}][score]"]`);
            const gradeEl = document.getElementById(`grade-${studentId}`);
            if (!scoreInput || !gradeEl) return;

            const score = parseFloat(scoreInput.value);

            if (isNaN(score)) {
                gradeEl.textContent = '-';
                gradeEl.className = 'inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                return;
            }

            let letter = 'E';
            let className = 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';

            if (score >= 90) { letter = 'A'; className = 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'; }
            else if (score >= 80) { letter = 'B'; className = 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100'; }
            else if (score >= 70) { letter = 'C'; className = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'; }
            else if (score >= 60) { letter = 'D'; className = 'bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100'; }

            gradeEl.textContent = letter;
            gradeEl.className = `inline-flex px-2 py-1 text-xs font-semibold rounded-full ${className}`;
        };

        // initial placeholders
        resetSelect(subjectSelect, 'Mata Pelajaran');
        resetSelect(examSelect, 'Ujian');
    });
</script>
@endsection

