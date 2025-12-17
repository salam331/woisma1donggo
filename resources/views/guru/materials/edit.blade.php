@extends('layouts.app')

@section('title', 'Edit Materi Pembelajaran - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b dark:border-gray-700">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('guru.materials.show', $material) }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Materi Pembelajaran</h1>
                    </div>
                </div>
            </div>
        </header>

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
                    <form method="POST" action="{{ route('guru.materials.update', $material) }}" enctype="multipart/form-data" id="materialForm">
                        @csrf
                        @method('PUT')

                        <!-- Current File Information -->
                        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border border-blue-200 dark:border-blue-700">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">
                                <i class="fas fa-info-circle mr-2"></i>File Saat Ini
                            </h3>
                            <div class="flex items-center space-x-4">
                                @if($material->mime_type && str_starts_with($material->mime_type, 'image/'))
                                    <img src="{{ asset('storage/' . $material->file_path) }}" 
                                         alt="{{ $material->file_name }}"
                                         class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                        <i class="fas fa-file text-gray-500 dark:text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ $material->file_name }}</p>
                                    <p class="text-xs text-blue-600 dark:text-blue-300">
                                        @php
                                            if ($material->file_size == 0) {
                                                echo '0 Bytes';
                                            } else {
                                                $k = 1024;
                                                $sizes = ['Bytes', 'KB', 'MB', 'GB'];
                                                $i = floor(log($material->file_size) / log($k));
                                                echo round($material->file_size / pow($k, $i), 2) . ' ' . $sizes[$i];
                                            }
                                        @endphp
                                        - {{ $material->mime_type ?? 'Unknown' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 1: Pilih Kelas -->
                        <div class="mb-6">
                            <label for="class_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-users mr-2"></i>Pilih Kelas yang Anda Ajar *
                            </label>
                            <select id="class_id" name="class_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $material->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }} - {{ $class->grade_level }} {{ $class->major ? '(' . $class->major . ')' : '' }}
                                </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 2: Pilih Mata Pelajaran -->
                        <div class="mb-6">
                            <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-book mr-2"></i>Pilih Mata Pelajaran *
                            </label>
                            <select id="subject_id" name="subject_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id', $material->subject_id) == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 3: Judul Materi -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-heading mr-2"></i>Judul Materi *
                            </label>
                            <input id="title" type="text" name="title" value="{{ old('title', $material->title) }}" required
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: Materi Photosynthesis Kelas X">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 4: Deskripsi -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-align-left mr-2"></i>Deskripsi Materi
                            </label>
                            <textarea id="description" name="description" rows="4"
                                      class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Deskripsi singkat tentang materi pembelajaran ini...">{{ old('description', $material->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 5: Upload File Baru (Optional) -->
                        <div class="mb-6">
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-upload mr-2"></i>Ganti File (Opsional)
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-blue-500 transition duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="file" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Pilih file baru</span>
                                            <input id="file" name="file" type="file"
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
                                    <div id="noFile" class="hidden mt-2 p-2 bg-gray-50 dark:bg-gray-700 rounded text-sm">
                                        <p class="text-gray-600 dark:text-gray-400">File tidak dipilih - file lama akan tetap digunakan</p>
                                    </div>
                                </div>
                            </div>
                            @error('file')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Preview -->
                        <div id="filePreview" class="hidden mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                                <i class="fas fa-file mr-2"></i>Preview File Baru
                            </h4>
                            <div id="previewContent" class="text-sm text-gray-600 dark:text-gray-300"></div>
                        </div>

                        <!-- Step 6: Visibility Settings -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                <i class="fas fa-eye mr-2"></i>Pengaturan Visibilitas
                            </label>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input id="is_public_yes" name="is_public" type="radio" value="1" {{ old('is_public', $material->is_public) == 1 ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="is_public_yes" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                        <span class="font-medium">Materi Publik</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Materi dapat dilihat oleh semua guru dan siswa
                                        </p>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="is_public_no" name="is_public" type="radio" value="0" {{ old('is_public', $material->is_public) == 0 ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="is_public_no" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                        <span class="font-medium">Materi Private</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Materi hanya dapat dilihat oleh Anda
                                        </p>
                                    </label>
                                </div>
                            </div>
                            @error('is_public')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t dark:border-gray-600">
                            <a href="{{ route('guru.materials.show', $material) }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
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
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const filePreview = document.getElementById('filePreview');
    const previewContent = document.getElementById('previewContent');
    const noFile = document.getElementById('noFile');
    const form = document.getElementById('materialForm');

    // Handle file input change
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Show file info
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileInfo.classList.remove('hidden');
            noFile.classList.add('hidden');

            // Show file preview
            showFilePreview(file);
        } else {
            fileInfo.classList.add('hidden');
            noFile.classList.remove('hidden');
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

    // Dynamic subject dropdown based on class selection
    const classSelect = document.getElementById('class_id');
    const subjectSelect = document.getElementById('subject_id');
    const originalSubjectOptions = Array.from(subjectSelect.options);

    classSelect.addEventListener('change', function() {
        const classId = this.value;
        
        // Clear subject dropdown
        subjectSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
        
        if (classId) {
            // Fetch subjects for this class
            fetch(`/guru/materials/get-subjects-by-class/${classId}`)
                .then(response => response.json())
                .then(data => {
                    // Add new options
                    data.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = subject.name;
                        subjectSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching subjects:', error);
                    // Restore original options on error
                    originalSubjectOptions.forEach(option => {
                        subjectSelect.appendChild(option.cloneNode(true));
                    });
                });
        } else {
            // Restore original options when no class is selected
            originalSubjectOptions.forEach(option => {
                subjectSelect.appendChild(option.cloneNode(true));
            });
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

    // Form validation
    form.addEventListener('submit', function(e) {
        const classId = document.getElementById('class_id').value;
        const subjectId = document.getElementById('subject_id').value;
        const title = document.getElementById('title').value.trim();
        const file = fileInput.files[0];

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

        // Check file size if new file is uploaded
        if (file && file.size > 50 * 1024 * 1024) {
            e.preventDefault();
            alert('Ukuran file terlalu besar. Maksimal 50MB.');
            fileInput.value = '';
            return;
        }
    });

    // Show "no file" message initially
    noFile.classList.remove('hidden');
});
</script>
@endsection

