@extends('layouts.app')

@section('title', 'Tambah Ujian')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.exams.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Ujian')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="school_class_id" :value="__('Kelas')" />
                            <select name="school_class_id" id="school_class_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Kelas</option>
                                @foreach($schoolClasses as $schoolClass)
                                    <option value="{{ $schoolClass->id }}" {{ old('school_class_id') == $schoolClass->id ? 'selected' : '' }}>
                                        {{ $schoolClass->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('school_class_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="teacher_id" :value="__('Guru')" />
                            <select name="teacher_id" id="teacher_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Guru</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="subject_id" :value="__('Mata Pelajaran')" />
                            <select name="subject_id" id="subject_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="exam_date" :value="__('Tanggal Ujian')" />
                            <x-text-input id="exam_date" class="block mt-1 w-full" type="date" name="exam_date" :value="old('exam_date')" required />
                            <x-input-error :messages="$errors->get('exam_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="start_time" :value="__('Waktu Mulai')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" type="time" step="60" name="start_time" :value="old('start_time')" required />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="end_time" :value="__('Waktu Selesai')" />
                            <x-text-input id="end_time" class="block mt-1 w-full" type="time" step="60" name="end_time" :value="old('end_time')" required />
                            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="total_score" :value="__('Skor Total')" />
                            <x-text-input id="total_score" class="block mt-1 w-full" type="number" step="0.01" name="total_score" :value="old('total_score')" required />
                            <x-input-error :messages="$errors->get('total_score')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="publish" class="inline-flex items-center">
                                <input id="publish" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="publish" value="1" {{ old('publish') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Publish ke siswa') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.exams.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Ujian') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- @endsection --}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    const schoolClassSelect = document.getElementById('school_class_id');
    const teacherSelect = document.getElementById('teacher_id');
    const subjectSelect = document.getElementById('subject_id');

    // Load teachers when class is selected
    schoolClassSelect.addEventListener('change', function() {
        const classId = this.value;
        if (classId) {
            fetch(`{{ url('admin/exams/get-teachers') }}/${classId}`)
                .then(response => response.json())
                .then(data => {
                    teacherSelect.innerHTML = '<option value="">Pilih Guru</option>';
                    data.forEach(teacher => {
                        teacherSelect.innerHTML += `<option value="${teacher.id}">${teacher.name}</option>`;
                    });
                    // Reset subject select
                    subjectSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
                })
                .catch(error => {
                    console.error('Error loading teachers:', error);
                    teacherSelect.innerHTML = '<option value="">Error loading teachers</option>';
                    subjectSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
                });
        } else {
            teacherSelect.innerHTML = '<option value="">Pilih Guru</option>';
            subjectSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
        }
    });

    // Load subjects when teacher is selected
    teacherSelect.addEventListener('change', function() {
        const teacherId = this.value;
        const classId = schoolClassSelect.value;
        if (teacherId && classId) {
            fetch(`{{ url('admin/exams/get-subjects') }}/${teacherId}?class_id=${classId}`)
                .then(response => response.json())
                .then(data => {
                    subjectSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
                    data.forEach(subject => {
                        subjectSelect.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error loading subjects:', error);
                    subjectSelect.innerHTML = '<option value="">Error loading subjects</option>';
                });
        } else {
            subjectSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
        }
    });
});
</script>

