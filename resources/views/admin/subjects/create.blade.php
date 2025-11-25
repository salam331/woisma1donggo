@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran Baru')

@section('content')

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                Tambah Mata Pelajaran Baru
            </h2>
            <a href="{{ route('admin.subjects.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
        <form method="POST" action="{{ route('admin.subjects.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Left Column -->
                <div class="space-y-4">

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Mata
                            Pelajaran</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Code -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Mata
                            Pelajaran</label>
                        <input id="code" type="text" name="code" value="{{ old('code') }}" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Contoh: MTK, IPA, IPS">
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teacher -->
                    <div>
                        <label for="teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Guru
                            Pengajar (Opsional)</label>
                        <select id="teacher_id" name="teacher_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
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

                </div>

                <!-- Right Column -->
                <div class="space-y-4">

                    <!-- Description -->
                    <div>
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi (Opsional)</label>
                        <textarea id="description" name="description" rows="6"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Deskripsikan tentang mata pelajaran ini...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan Mata Pelajaran
                </button>
            </div>

        </form>
    </div>

@endsection