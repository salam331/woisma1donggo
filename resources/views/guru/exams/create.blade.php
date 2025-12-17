@extends('layouts.app')

@section('title', 'Buat Ujian Baru - Guru Dashboard')

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
                                Buat Ujian Baru
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                Buat ujian baru untuk mata pelajaran yang Anda ajar
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('guru.exams.index') }}"
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
                    <form method="POST" action="{{ route('guru.exams.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Exam Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nama Ujian <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Contoh: Ujian Tengah Semester 1"
                                           required>
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
                                                    {{ old('school_class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                                    {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="subject-loading" class="hidden mt-1">
                                        <div class="flex items-center text-sm text-blue-600 dark:text-blue-400">
                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Memuat mata pelajaran...
                                        </div>
                                    </div>
                                </div>

                                <!-- Exam Date -->
                                <div>
                                    <label for="exam_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Tanggal Ujian <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="exam_date" name="exam_date" 
                                           value="{{ old('exam_date') }}"
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
                                           value="{{ old('start_time') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>

                                <!-- End Time -->
                                <div>
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Waktu Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="end_time" name="end_time" 
                                           value="{{ old('end_time') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>

                                <!-- Total Score -->
                                <div>
                                    <label for="total_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Skor Maksimal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="total_score" name="total_score" 
                                           value="{{ old('total_score', 100) }}"
                                           min="1" max="100" step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="100"
                                           required>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Skor maksimal untuk ujian ini (1-100)
                                    </p>
                                </div>

                                <!-- Publish Status -->
                                <div>
                                    <div class="flex items-center">
                                        <input id="publish" name="publish" type="checkbox" value="1" 
                                               {{ old('publish') ? 'checked' : '' }}
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
                                      placeholder="Masukkan deskripsi ujian, materi yang diujikan, atau instruksi khusus...">{{ old('description') }}</textarea>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('guru.exams.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-plus mr-2"></i>Buat Ujian
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Help Section -->
                <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">
                        <i class="fas fa-info-circle mr-2"></i>Tips Membuat Ujian
                    </h3>
                    <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                        <li>• Pastikan jadwal ujian tidak bentrok dengan ujian lain</li>
                        <li>• Berikan deskripsi yang jelas tentang materi yang diujikan</li>
                        <li>• Atur skor maksimal sesuai dengan bobot ujian</li>
                        <li>• Pastikan kelas dan mata pelajaran sesuai dengan jadwal mengajar Anda</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Calculate duration automatically and validate time
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
                // You can add UI feedback here
            } else if (diff < 0) {
                console.log('Waktu selesai harus setelah waktu mulai');
                alert('Waktu selesai harus setelah waktu mulai!');
                endTime.value = '';
            }
        }
    }
    
    startTime.addEventListener('change', calculateDuration);
    endTime.addEventListener('change', calculateDuration);
    

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('exam_date').setAttribute('min', today);

    // Handle dynamic subject loading based on selected class
    const classSelect = document.getElementById('school_class_id');
    const subjectSelect = document.getElementById('subject_id');
    const subjectLoading = document.getElementById('subject-loading');
    const allSubjects = @json($subjects); // Pass all subjects to JavaScript

    function loadSubjectsByClass(classId) {
        if (!classId) {
            // Reset to all subjects if no class selected
            resetSubjectsToAll();
            return;
        }

        // Show loading indicator
        subjectLoading.classList.remove('hidden');
        subjectSelect.disabled = true;

        // Make AJAX request
        fetch(`/guru/exams/get-subjects-by-class/${classId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(subjects => {
                // Clear existing options
                subjectSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
                
                // Add filtered subjects
                subjects.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.id;
                    option.textContent = subject.name;
                    subjectSelect.appendChild(option);
                });

                // Hide loading indicator
                subjectLoading.classList.add('hidden');
                subjectSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error loading subjects:', error);
                alert('Terjadi kesalahan saat memuat mata pelajaran. Silakan coba lagi.');
                
                // Hide loading indicator and re-enable select
                subjectLoading.classList.add('hidden');
                subjectSelect.disabled = false;
                
                // Reset to all subjects as fallback
                resetSubjectsToAll();
            });
    }

    function resetSubjectsToAll() {
        subjectSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
        allSubjects.forEach(subject => {
            const option = document.createElement('option');
            option.value = subject.id;
            option.textContent = subject.name;
            subjectSelect.appendChild(option);
        });
    }

    // Listen for class selection changes
    classSelect.addEventListener('change', function() {
        const classId = this.value;
        loadSubjectsByClass(classId);
    });

    // If there's an old value for class, load subjects for that class on page load
    const oldClassId = '{{ old('school_class_id') }}';
    if (oldClassId) {
        loadSubjectsByClass(oldClassId);
    }
});
</script>
@endsection
