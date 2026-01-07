@extends('layouts.app')

@section('title', 'Tambah Materi Pembelajaran - Admin Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-4xl mx-auto">
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
                    <form method="POST" action="{{ route('admin.materials.store') }}" enctype="multipart/form-data" id="materialForm">
                        @csrf

                        <!-- Step 1: Pilih Guru -->
                        <div class="mb-6">
                            <label for="teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-user-graduate mr-2"></i>Pilih Guru *
                            </label>
                            <select id="teacher_id" name="teacher_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Guru Pengajar</option>
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }} - {{ $teacher->nip }}
                                </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 2: Pilih Kelas -->
                        <div class="mb-6">
                            <label for="class_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-users mr-2"></i>Pilih Kelas *
                            </label>
                            <select id="class_id" name="class_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" disabled>
                                <option value="">Pilih Guru terlebih dahulu</option>
                            </select>
                            @error('class_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 3: Pilih Mata Pelajaran -->
                        <div class="mb-6">
                            <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-book mr-2"></i>Pilih Mata Pelajaran *
                            </label>
                            <select id="subject_id" name="subject_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" disabled>
                                <option value="">Pilih Guru dan Kelas terlebih dahulu</option>
                            </select>
                            @error('subject_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 4: Judul Materi -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-heading mr-2"></i>Judul Materi *
                            </label>
                            <input id="title" type="text" name="title" value="{{ old('title') }}" required
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: Materi Photosynthesis Kelas X">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 5: Deskripsi -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-align-left mr-2"></i>Deskripsi Materi
                            </label>
                            <textarea id="description" name="description" rows="4"
                                      class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Deskripsi singkat tentang materi pembelajaran ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 6: Upload File -->
                        <div class="mb-6">
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-upload mr-2"></i>File Materi *
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-blue-500 transition duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="file" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload file</span>
                                            <input id="file" name="file" type="file" required
                                                   class="sr-only"
                                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, JPG, JPEG, PNG, GIF, MP4, AVI, MOV (max 50MB)
                                    </p>
                                    <div id="fileInfo" class="hidden mt-2 p-2 bg-blue-50 dark:bg-blue-900 rounded text-sm">
                                        <p class="text-blue-800 dark:text-blue-200">
                                            <span id="fileName"></span> - <span id="fileSize"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @error('file')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 7: Visibility Settings -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                <i class="fas fa-eye mr-2"></i>Pengaturan Visibilitas
                            </label>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input id="is_public_yes" name="is_public" type="radio" value="1" {{ old('is_public', 1) == 1 ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="is_public_yes" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                        <span class="font-medium">Materi Publik</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Materi dapat dilihat oleh semua guru dan siswa
                                        </p>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="is_public_no" name="is_public" type="radio" value="0" {{ old('is_public', 1) == 0 ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="is_public_no" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                        <span class="font-medium">Materi Private</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Materi hanya dapat dilihat oleh admin dan guru terkait
                                        </p>
                                    </label>
                                </div>
                            </div>
                            @error('is_public')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Preview -->
                        <div id="filePreview" class="hidden mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                                <i class="fas fa-file mr-2"></i>Preview File
                            </h4>
                            <div id="previewContent" class="text-sm text-gray-600 dark:text-gray-300"></div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t dark:border-gray-600">
                            <a href="{{ route('admin.materials.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                <i class="fas fa-upload mr-2"></i>Upload Materi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Get CSRF token from meta tag (added in layout)
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const filePreview = document.getElementById('filePreview');
    const previewContent = document.getElementById('previewContent');
    const form = document.getElementById('materialForm');

    // Handle file input change
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Show file info
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileInfo.classList.remove('hidden');

            // Show file preview
            showFilePreview(file);
        } else {
            fileInfo.classList.add('hidden');
            filePreview.classList.add('hidden');
        }
    });

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Show file preview based on type
    function showFilePreview(file) {
        const fileType = file.type;
        const fileName = file.name.toLowerCase();

        previewContent.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    ${getFileIcon(fileType, fileName)}
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900 dark:text-gray-100">${file.name}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">${formatFileSize(file.size)} - ${fileType || 'Unknown'}</p>
                </div>
            </div>
        `;
        filePreview.classList.remove('hidden');
    }

    // Get file icon based on type
    function getFileIcon(fileType, fileName) {
        if (fileType.startsWith('image/')) {
            return '<i class="fas fa-file-image text-green-500 text-2xl"></i>';
        } else if (fileType === 'application/pdf') {
            return '<i class="fas fa-file-pdf text-red-500 text-2xl"></i>';
        } else if (fileType.includes('word') || fileName.endsWith('.doc') || fileName.endsWith('.docx')) {
            return '<i class="fas fa-file-word text-blue-500 text-2xl"></i>';
        } else if (fileType.includes('sheet') || fileName.endsWith('.xls') || fileName.endsWith('.xlsx')) {
            return '<i class="fas fa-file-excel text-green-500 text-2xl"></i>';
        } else if (fileType.includes('presentation') || fileName.endsWith('.ppt') || fileName.endsWith('.pptx')) {
            return '<i class="fas fa-file-powerpoint text-orange-500 text-2xl"></i>';
        } else if (fileType.startsWith('video/')) {
            return '<i class="fas fa-file-video text-purple-500 text-2xl"></i>';
        } else {
            return '<i class="fas fa-file text-gray-500 text-2xl"></i>';
        }
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        const file = fileInput.files[0];
        const teacherId = document.getElementById('teacher_id').value;
        const classId = document.getElementById('class_id').value;
        const subjectId = document.getElementById('subject_id').value;
        const title = document.getElementById('title').value.trim();

        if (!teacherId) {
            e.preventDefault();
            alert('Silakan pilih guru pengajar terlebih dahulu.');
            document.getElementById('teacher_id').focus();
            return;
        }

        if (!classId) {
            e.preventDefault();
            alert('Silakan pilih kelas terlebih dahulu.');
            document.getElementById('class_id').focus();
            return;
        }

        if (!subjectId) {
            e.preventDefault();
            alert('Silakan pilih mata pelajaran terlebih dahulu.');
            document.getElementById('subject_id').focus();
            return;
        }

        if (!title) {
            e.preventDefault();
            alert('Silakan masukkan judul materi.');
            document.getElementById('title').focus();
            return;
        }

        if (!file) {
            e.preventDefault();
            alert('Silakan pilih file untuk diupload.');
            fileInput.focus();
            return;
        }

        // Check file size (50MB max)
        if (file.size > 50 * 1024 * 1024) {
            e.preventDefault();
            alert('Ukuran file terlalu besar. Maksimal 50MB.');
            fileInput.value = '';
            return;
        }
    });

    // Drag and drop functionality
    const dropZone = document.querySelector('.border-dashed');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    // =====================================================
    // DYNAMIC DROPDOWN FUNCTIONALITY
    // When teacher is selected, load classes.
    // When class is selected, load subjects based on both teacher AND class.
    // =====================================================
    const teacherSelect = document.getElementById('teacher_id');
    const classSelect = document.getElementById('class_id');
    const subjectSelect = document.getElementById('subject_id');

    // Event listener untuk perubahan guru
    teacherSelect.addEventListener('change', function(e) {
        const teacherId = e.target.value;
        loadClassesByTeacher(teacherId);
        // Reset kelas dan mata pelajaran
        classSelect.value = '';
        subjectSelect.value = '';
    });

    // Event listener untuk perubahan kelas
    classSelect.addEventListener('change', function(e) {
        const teacherId = teacherSelect.value;
        const classId = e.target.value;
        if (teacherId && classId) {
            loadSubjectsByTeacherClass(teacherId, classId);
        } else {
            subjectSelect.innerHTML = '<option value="">Pilih Guru dan Kelas terlebih dahulu</option>';
            subjectSelect.disabled = true;
        }
        // Reset mata pelajaran
        subjectSelect.value = '';
    });

    // Function to load classes by teacher
    async function loadClassesByTeacher(teacherId) {
        if (!teacherId) {
            classSelect.innerHTML = '<option value="">Pilih Guru terlebih dahulu</option>';
            classSelect.disabled = true;
            subjectSelect.innerHTML = '<option value="">Pilih Guru dan Kelas terlebih dahulu</option>';
            subjectSelect.disabled = true;
            return;
        }

        classSelect.innerHTML = '<option value="">Memuat kelas...</option>';
        classSelect.disabled = false;
        subjectSelect.innerHTML = '<option value="">Pilih Guru dan Kelas terlebih dahulu</option>';
        subjectSelect.disabled = true;

        try {
            const url = `/admin/materials/get-classes-by-teacher/${teacherId}`;
            console.log('Fetching classes from:', url);
            
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('HTTP Error Response:', response.status, errorText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const classes = await response.json();
            console.log('Classes received:', classes);
            
            if (!classes || classes.length === 0) {
                classSelect.innerHTML = '<option value="">Tidak ada kelas untuk guru ini</option>';
                classSelect.disabled = true;
                subjectSelect.innerHTML = '<option value="">Pilih Guru dan Kelas terlebih dahulu</option>';
                subjectSelect.disabled = true;
                return;
            }

            let classOptions = '<option value="">Pilih Kelas</option>';
            classes.forEach(schoolClass => {
                classOptions += `<option value="${schoolClass.id}">${schoolClass.name}</option>`;
            });
            
            classSelect.innerHTML = classOptions;
            classSelect.disabled = false;
            console.log('Classes dropdown updated successfully');
        } catch (error) {
            console.error('Error loading classes:', error);
            classSelect.innerHTML = '<option value="">Error memuat kelas</option>';
            classSelect.disabled = true;
        }
    }

    // Function to load subjects by teacher and class
    async function loadSubjectsByTeacherClass(teacherId, classId) {
        if (!teacherId || !classId) {
            subjectSelect.innerHTML = '<option value="">Pilih Guru dan Kelas terlebih dahulu</option>';
            subjectSelect.disabled = true;
            return;
        }

        subjectSelect.innerHTML = '<option value="">Memuat mata pelajaran...</option>';
        subjectSelect.disabled = false;

        try {
            const url = `/admin/materials/get-subjects-by-teacher-class/${teacherId}/${classId}`;
            console.log('Fetching subjects from:', url);
            
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('HTTP Error Response:', response.status, errorText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const subjects = await response.json();
            console.log('Subjects received:', subjects);
            
            if (!subjects || subjects.length === 0) {
                subjectSelect.innerHTML = '<option value="">Tidak ada mata pelajaran untuk guru dan kelas ini</option>';
                subjectSelect.disabled = true;
                return;
            }

            let subjectOptions = '<option value="">Pilih Mata Pelajaran</option>';
            subjects.forEach(subject => {
                subjectOptions += `<option value="${subject.id}">${subject.name}</option>`;
            });
            
            subjectSelect.innerHTML = subjectOptions;
            subjectSelect.disabled = false;
            console.log('Subjects dropdown updated successfully');
        } catch (error) {
            console.error('Error loading subjects:', error);
            subjectSelect.innerHTML = '<option value="">Error memuat mata pelajaran</option>';
            subjectSelect.disabled = true;
        }
    }
});
</script>
@endsection

