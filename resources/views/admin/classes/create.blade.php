<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Kelas Baru
            </h2>
            <a href="{{ route('admin.classes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.classes.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Grade Level -->
                                <div>
                                    <label for="grade_level" class="block text-sm font-medium text-gray-700">Tingkat Kelas</label>
                                    <select id="grade_level" name="grade_level" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Tingkat Kelas</option>
                                        <option value="Kelas 1" {{ old('grade_level') == 'Kelas 1' ? 'selected' : '' }}>Kelas 1</option>
                                        <option value="Kelas 2" {{ old('grade_level') == 'Kelas 2' ? 'selected' : '' }}>Kelas 2</option>
                                        <option value="Kelas 3" {{ old('grade_level') == 'Kelas 3' ? 'selected' : '' }}>Kelas 3</option>
                                        <option value="Kelas 4" {{ old('grade_level') == 'Kelas 4' ? 'selected' : '' }}>Kelas 4</option>
                                        <option value="Kelas 5" {{ old('grade_level') == 'Kelas 5' ? 'selected' : '' }}>Kelas 5</option>
                                        <option value="Kelas 6" {{ old('grade_level') == 'Kelas 6' ? 'selected' : '' }}>Kelas 6</option>
                                        <option value="Kelas 7" {{ old('grade_level') == 'Kelas 7' ? 'selected' : '' }}>Kelas 7</option>
                                        <option value="Kelas 8" {{ old('grade_level') == 'Kelas 8' ? 'selected' : '' }}>Kelas 8</option>
                                        <option value="Kelas 9" {{ old('grade_level') == 'Kelas 9' ? 'selected' : '' }}>Kelas 9</option>
                                        <option value="Kelas 10" {{ old('grade_level') == 'Kelas 10' ? 'selected' : '' }}>Kelas 10</option>
                                        <option value="Kelas 11" {{ old('grade_level') == 'Kelas 11' ? 'selected' : '' }}>Kelas 11</option>
                                        <option value="Kelas 12" {{ old('grade_level') == 'Kelas 12' ? 'selected' : '' }}>Kelas 12</option>
                                    </select>
                                    @error('grade_level')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teacher -->
                                <div>
                                    <label for="teacher_id" class="block text-sm font-medium text-gray-700">Wali Kelas (Opsional)</label>
                                    <select id="teacher_id" name="teacher_id"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
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
                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                                    <textarea id="description" name="description" rows="4"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
