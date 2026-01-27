@extends('layouts.app')

@section('title', 'Edit Nilai Siswa - ' . $exam->name . ' - ' . $subject->name)

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Edit Nilai Siswa - {{ $exam->name }}</h3>
                            <nav class="text-sm text-gray-500">
                                <a href="{{ route('admin.grades.index') }}" class="hover:text-blue-600">Nilai Siswa</a> >
                                <a href="{{ route('admin.grades.class', $schoolClass->id) }}"
                                    class="hover:text-blue-600">{{ $schoolClass->name }}</a> >
                                <a href="{{ route('admin.grades.subject', [$schoolClass->id, $subject->id]) }}"
                                    class="hover:text-blue-600">{{ $subject->name }}</a> >
                                <span>{{ $exam->name }}</span>
                            </nav>
                        </div>
                        <a href="{{ route('admin.grades.exam', [$schoolClass->id, $subject->id, $exam->id]) }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                    </div>

                    {{-- Session alerts removed - now using toast notifications --}}

                    <form method="POST"
                        action="{{ route('admin.grades.update-exam', [$schoolClass->id, $subject->id, $exam->id]) }}">
                        @csrf
                        @method('PUT')

                        {{-- KELAS (READONLY) --}}
                        <div class="mb-4">
                            <x-input-label for="class_display" :value="__('Kelas')" />
                            <x-text-input id="class_display" class="block mt-1 w-full bg-gray-100" type="text"
                                value="{{ $schoolClass->name }}" readonly />
                        </div>

                        {{-- MATA PELAJARAN (READONLY) --}}
                        <div class="mb-4">
                            <x-input-label for="subject_display" :value="__('Mata Pelajaran')" />
                            <x-text-input id="subject_display" class="block mt-1 w-full bg-gray-100" type="text"
                                value="{{ $subject->name }}" readonly />
                        </div>

                        {{-- UJIAN (READONLY) --}}
                        <div class="mb-4">
                            <x-input-label for="exam_display" :value="__('Ujian')" />
                            <x-text-input id="exam_display" class="block mt-1 w-full bg-gray-100" type="text"
                                value="{{ $exam->name }}" readonly />
                        </div>

                        {{-- NILAI SISWA --}}
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

                                <tbody>
                                    @foreach($students as $student)
                                        @php
                                            $grade = $grades->where('student_id', $student->id)->first();
                                        @endphp

                                        <tr>
                                            {{-- Nama Siswa --}}
                                            <td class="border px-4 py-2">
                                                {{ $student->name }}
                                                <br>
                                                <span class="text-xs text-gray-500">NIS: {{ $student->nis }}</span>

                                                {{-- Agar student_id tetap terkirim --}}
                                                <input type="hidden" name="grades[{{ $student->id }}][student_id]"
                                                    value="{{ $student->id }}">
                                            </td>

                                            {{-- Nilai Angka --}}
                                            <td class="border px-4 py-2">
                                                <input type="number" step="0.01" name="grades[{{ $student->id }}][score]"
                                                    id="score_{{ $student->id }}" value="{{ $grade ? $grade->score : '' }}"
                                                    class="w-full border-gray-300 rounded-md"
                                                    oninput="updateGradeLetter({{ $student->id }})">
                                            </td>

                                            {{-- Grade Huruf --}}
                                            <td class="border px-4 py-2">
                                                <input type="text" name="grades[{{ $student->id }}][grade_letter]"
                                                    id="grade_letter_{{ $student->id }}"
                                                    value="{{ $grade ? $grade->grade_letter : '' }}"
                                                    class="w-full border-gray-300 rounded-md bg-gray-100" readonly>
                                            </td>

                                            {{-- Catatan --}}
                                            <td class="border px-4 py-2">
                                                <textarea name="grades[{{ $student->id }}][notes]"
                                                    class="w-full border-gray-300 rounded-md"
                                                    rows="1">{{ $grade ? $grade->notes : '' }}</textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.grades.exam', [$schoolClass->id, $subject->id, $exam->id]) }}"
                                class="mr-4 text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>
                                Update Semua Nilai
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // FUNGSI UPDATE GRADE HURUF
        function updateGradeLetter(studentId) {
            const score = parseFloat(document.getElementById('score_' + studentId).value);
            let grade = "";

            if (isNaN(score)) grade = "";
            else if (score >= 90) grade = "A";
            else if (score >= 80) grade = "B";
            else if (score >= 70) grade = "C";
            else if (score >= 60) grade = "D";
            else grade = "E";

            document.getElementById('grade_letter_' + studentId).value = grade;
        }
    </script>
@endsection