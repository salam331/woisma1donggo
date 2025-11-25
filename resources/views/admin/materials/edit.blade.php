@extends('layouts.app')

@section('title', 'Edit Materi: ' . $material->title)

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden justify-between">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                    Edit Materi: {{ $material->title }}
                </h2>
                <a href="{{ route('admin.materials.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>

            <form method="POST"
                  action="{{ route('admin.materials.update', $material) }}"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- LEFT COLUMN --}}
                    <div class="space-y-4">

                        {{-- Judul --}}
                        <div>
                            <label for="title" class="text-sm font-medium text-gray-700 dark:text-gray-300">Judul Materi</label>
                            <input id="title"
                                   type="text"
                                   name="title"
                                   value="{{ old('title', $material->title) }}"
                                   required
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">
                            @error('title')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Mata Pelajaran --}}
                        <div>
                            <label for="subject_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Mata Pelajaran
                            </label>
                            <select id="subject_id"
                                    name="subject_id"
                                    required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Mata Pelajaran</option>

                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ old('subject_id', $material->subject_id) == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} ({{ $subject->code }})
                                </option>
                                @endforeach

                            </select>
                            @error('subject_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Guru --}}
                        <div>
                            <label for="teacher_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Guru Pengajar
                            </label>
                            <select id="teacher_id"
                                    name="teacher_id"
                                    required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Guru Pengajar</option>

                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ old('teacher_id', $material->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }} - {{ $teacher->nip }}
                                </option>
                                @endforeach

                            </select>
                            @error('teacher_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- File Materi --}}
                        <div>
                            <label for="file" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                File Materi (Opsional)
                            </label>
                            <input id="file"
                                   type="file"
                                   name="file"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov"
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Biarkan kosong jika tidak ingin mengubah file. Maksimal 10MB.
                            </p>

                            @if($material->file_path)
                                <p class="mt-1 text-sm text-blue-600 dark:text-blue-300">
                                    File saat ini: {{ basename($material->file_path) }}
                                </p>
                            @endif

                            @error('file')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="space-y-4">
                        <div>
                            <label for="description" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Deskripsi (Opsional)
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="8"
                                      class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Deskripsikan tentang materi ini...">{{ old('description', $material->description) }}</textarea>

                            @error('description')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- Tombol Submit --}}
                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Update Materi
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
