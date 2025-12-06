@extends('layouts.app')

@section('title', 'Tambah Nilai Siswa')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('admin.grades.index') }}">
                        @csrf

                        {{-- kelas --}}
                        <div class="mb-4">
                            <x-input-label for="class_id" :value="__('Kelas')" />
                            <select name="class_id" id="class_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Kelas</option>
                                @foreach($schoolClasses as $schoolClass)
                                    <option value="{{ $schoolClass->id }}">{{ $schoolClass->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('class_id')" class="mt-2" />
                        </div>

                        {{-- Mata Pelajaran --}}
                        <div class="mb-4">
                            <x-input-label for="subject_id" :value="__('Mata Pelajaran')" />
                            <select name="subject_id" id="subject_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Mata Pelajaran</option>
                            </select>
                            <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                        </div>

                        {{-- Ujian --}}
                        <div class="mb-4">
                            <x-input-label for="exam_id" :value="__('Ujian')" />
                            <select name="exam_id" id="exam_id"
                                class="mt-1 block w-full border-gray-300 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Ujian</option>
                            </select>
                            <x-input-error :messages="$errors->get('exam_id')" class="mt-2" />
                        </div>

                        <hr class="my-6">

                        {{-- Tabel Input --}}
                        <h2 class="text-xl font-semibold mb-4">Input Nilai Siswa</h2>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-2 text-left">Nama Siswa</th>
                                        <th class="border px-4 py-2 text-left">Nilai Angka</th>
                                        <th class="border px-4 py-2 text-left">Grade</th>
                                        <th class="border px-4 py-2 text-left">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody id="students-table-body">
                                    <!-- Siswa akan dimuat secara dinamis -->
                                </tbody>
                            </table>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.grades.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Nilai') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk cascading selects dan grade otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classSelect = document.getElementById('class_id');
            const subjectSelect = document.getElementById('subject_id');
            const examSelect = document.getElementById('exam_id');
            const studentsTableBody = document.getElementById('students-table-body');

            // Ketika kelas dipilih, muat mata pelajaran dan siswa
            classSelect.addEventListener('change', function() {
                const classId = this.value;
                if (classId) {
                    loadSubjects(classId);
                    loadStudents(classId);
                } else {
                    resetSelect(subjectSelect);
                    resetSelect(examSelect);
                    studentsTableBody.innerHTML = '';
                }
            });

            // Ketika mata pelajaran dipilih, muat ujian
            subjectSelect.addEventListener('change', function() {
                const classId = classSelect.value;
                const subjectId = this.value;
                if (classId && subjectId) {
                    loadExams(classId, subjectId);
                } else {
                    resetSelect(examSelect);
                }
            });

            function loadSubjects(classId) {
                fetch(`/admin/grades/get-subjects/${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        resetSelect(subjectSelect);
                        data.forEach(subject => {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.textContent = subject.name;
                            subjectSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error loading subjects:', error));
            }

            function loadExams(classId, subjectId) {
                fetch(`/admin/grades/get-exams/${classId}/${subjectId}`)
                    .then(response => response.json())
                    .then(data => {
                        resetSelect(examSelect);
                        data.forEach(exam => {
                            const option = document.createElement('option');
                            option.value = exam.id;
                            option.textContent = exam.name;
                            examSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error loading exams:', error));
            }

            function loadStudents(classId) {
                fetch(`/admin/grades/get-students/${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        studentsTableBody.innerHTML = '';
                        data.forEach((student, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <input type="hidden" name="grades[${index}][student_id]" value="${student.id}">
                                <td class="border px-4 py-2">${student.name}
                                    <br>
                                    <span class="text-xs text-gray-500">NIS: ${student.nis}</span>
                                    </td>
                                <td class="border px-4 py-2">
                                    <input type="number" step="0.01" name="grades[${index}][score]"
                                        class="w-full border-gray-300 rounded-md" oninput="updateGrade(${index})">
                                </td>
                                <td class="border px-4 py-2">
                                    <input type="text" name="grades[${index}][grade_letter]" id="grade_letter_${index}"
                                        class="w-full border-gray-300 rounded-md bg-gray-100" readonly>
                                </td>
                                <td class="border px-4 py-2">
                                    <textarea name="grades[${index}][notes]" class="w-full border-gray-300 rounded-md" rows="1"></textarea>
                                </td>
                            `;
                            studentsTableBody.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Error loading students:', error));
            }

            function resetSelect(selectElement) {
                selectElement.innerHTML = '<option value="">Pilih ' + selectElement.previousElementSibling.textContent + '</option>';
            }
        });

        function updateGrade(index) {
            const score = parseFloat(document.querySelector(`[name="grades[${index}][score]"]`).value);
            let grade = "";

            if (isNaN(score)) grade = "";
            else if (score >= 90) grade = "A";
            else if (score >= 80) grade = "B";
            else if (score >= 70) grade = "C";
            else if (score >= 60) grade = "D";
            else grade = "E";

            document.getElementById(`grade_letter_${index}`).value = grade;
        }
    </script>

@endsection
