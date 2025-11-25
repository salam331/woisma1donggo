@extends('layouts.app')

@section('title', 'Edit Orang Tua: ' . $parent->name)

@section('content')

    <div class="max-w-4xl mx-auto">
        <div class="p-6">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-100 dark:border-gray-700 p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">
                        Edit Orang Tua: {{ $parent->name }}
                    </h2>

                    <a href="{{ route('admin.parents.index') }}">
                        <button
                            class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                            Kembali
                        </button>
                    </a>
                </div>
                <form method="POST" action="{{ route('admin.parents.update', $parent) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- Left Column -->
                        <div class="space-y-5">

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                    Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $parent->name) }}" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $parent->email) }}"
                                    required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone', $parent->phone) }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-5">

                            <!-- Relationship -->
                            <div>
                                <label for="relationship"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hubungan dengan
                                    Siswa</label>
                                <select id="relationship" name="relationship" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Pilih Hubungan</option>
                                    <option value="father" {{ old('relationship', $parent->relationship) == 'father' ? 'selected' : '' }}>Ayah</option>
                                    <option value="mother" {{ old('relationship', $parent->relationship) == 'mother' ? 'selected' : '' }}>Ibu</option>
                                    <option value="guardian" {{ old('relationship', $parent->relationship) == 'guardian' ? 'selected' : '' }}>Wali</option>
                                </select>
                                @error('relationship')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Current Photo -->
                            @if($parent->photo)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Saat
                                        Ini</label>
                                    <img src="{{ asset('storage/' . $parent->photo) }}"
                                        class="mt-2 h-24 w-24 rounded-full object-cover shadow">
                                </div>
                            @endif

                            <!-- Upload Photo -->
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $parent->photo ? 'Ganti Foto' : 'Foto' }}
                                </label>
                                <input id="photo" type="file" name="photo" accept="image/*"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('photo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Format: JPG, PNG, GIF (max 2MB).
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mt-8">
                        <label for="address"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                        <textarea id="address" name="address" rows="4"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('address', $parent->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                            Update Orang Tua
                        </button>
                    </div>

                </form>
            </div>
        </div>

@endsection