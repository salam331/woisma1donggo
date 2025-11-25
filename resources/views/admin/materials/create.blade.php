@extends('layouts.app')

@section('title', 'Tambah Materi Pelajaran Baru')

@section('content')

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100">
                        Tambah Materi Pelajaran Baru
                    </h2>
                    <a href="{{ route('admin.materials.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.materials.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Left Column -->
                        <div class="space-y-4">

                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Judul Materi
                                </label>
                                <input id="title" type="text" name="title" value="{{ old('title') }}" required
                                    class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Mata Pelajaran
                                </label>
                                <select id="subject_id" name="subject_id" required
                                    class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }} ({{ $subject->code }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('subject_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teacher -->
                            <div>
                                <label for="teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Guru Pengajar
                                </label>
                                <select id="teacher_id" name="teacher_id" required
                                    class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Guru Pengajar</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }} - {{ $teacher->nip }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('teacher_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- File Upload -->
                            <div>
                                <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    File Materi
                                </label>
                                <input id="file" type="file" name="file" required
                                    class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov">

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Maksimal 10MB. Format: PDF, DOC, PPT, XLS, JPG, PNG, GIF, MP4, AVI, MOV
                                </p>

                                @error('file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Deskripsi (Opsional)
                                </label>
                                <textarea id="description" name="description" rows="8"
                                    class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Deskripsikan tentang materi ini...">{{ old('description') }}</textarea>

                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-6">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none">
                            Simpan Materi
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection