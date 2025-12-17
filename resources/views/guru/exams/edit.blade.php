@extends('layouts.app')

@section('title', 'Edit Ujian - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Edit Ujian: {{ $exam->name }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                {{ $exam->subject->name ?? 'N/A' }} - 
                                {{ $exam->schoolClass->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('guru.exams.show', $exam) }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                    <form method="POST" action="{{ route('guru.exams.update', $exam) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Exam Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nama Ujian <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $exam->name) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>

                                <!-- Subject -->
                                <div>
                                    <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Mata Pelajaran <span class="text-red-500">*</span>
                                    </label>
                                    <select id="subject_id" name="subject_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Pilih Mata Pelajaran</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" 
                                                    {{ old('subject_id', $exam->subject_id) == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Class -->
                                <div>
                                    <label for="school_class_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Kelas <span class="text-red-500">*</span>
                                    </label>
                                    <select id="school_class_id" name="school_class_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Pilih Kelas</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" 
                                                    {{ old('school_class_id', $exam->school_class_id) == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Exam Date -->
                                <div>
                                    <label for="exam_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Tanggal Ujian <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="exam_date" name="exam_date" 
                                           value="{{ old('exam_date', $exam->exam_date ? $exam->exam_date->format('Y-m-d') : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Start Time -->
                                <div>
                                    <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Waktu Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="start_time" name="start_time"
                                           value="{{ old('start_time', $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('H:i') : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>

                                <!-- End Time -->
                                <div>
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Waktu Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="end_time" name="end_time"
                                           value="{{ old('end_time', $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('H:i') : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>

                                <!-- Total Score -->
                                <div>
                                    <label for="total_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Skor Maksimal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="total_score" name="total_score" 
                                           value="{{ old('total_score', $exam->total_score) }}"
                                           min="1" max="100" step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>

                                <!-- Publish Status -->
                                <div>
                                    <div class="flex items-center">
                                        <input id="publish" name="publish" type="checkbox" value="1" 
                                               {{ old('publish', $exam->publish) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                                        <label for="publish" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Publikasikan Ujian
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Jika dicentang, ujian akan terlihat oleh siswa
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Deskripsi
                            </label>
                            <textarea id="description" name="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Masukkan deskripsi ujian...">{{ old('description', $exam->description) }}</textarea>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('guru.exams.show', $exam) }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Calculate duration automatically
document.addEventListener('DOMContentLoaded', function() {
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    
    function calculateDuration() {
        if (startTime.value && endTime.value) {
            const start = new Date('1970-01-01 ' + startTime.value);
            const end = new Date('1970-01-01 ' + endTime.value);
            const diff = (end - start) / (1000 * 60); // in minutes
            
            if (diff > 0) {
                console.log('Durasi: ' + diff + ' menit');
            } else if (diff < 0) {
                console.log('Waktu selesai harus setelah waktu mulai');
            }
        }
    }
    
    startTime.addEventListener('change', calculateDuration);
    endTime.addEventListener('change', calculateDuration);
});
</script>
@endsection
