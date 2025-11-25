@extends('layouts.app')

@section('title', 'Tambah Kelas Baru')

@section('content')

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">
                    Tambah Kelas Baru
                </h2>
                <a href="{{ route('admin.classes.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
            <form method="POST" action="{{ route('admin.classes.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Kelas</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                       focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grade Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat Kelas</label>
                            <select name="grade_level" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                       focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                                <option value="">Pilih Tingkat Kelas</option>
                                @foreach(range(1, 12) as $i)
                                    <option value="Kelas {{ $i }}" {{ old('grade_level') == "Kelas $i" ? 'selected' : '' }}>
                                        Kelas {{ $i }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grade_level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teacher -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wali Kelas
                                (Opsional)</label>
                            <select name="teacher_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                       focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                                <option value="">Pilih Wali Kelas</option>
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
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi
                                (Opsional)</label>
                            <textarea name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                       focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan Kelas
                    </button>
                </div>

            </form>
        </div>

    </div>

@endsection