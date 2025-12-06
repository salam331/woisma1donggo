@extends('layouts.app')

@section('title', 'Tambah Siswa Baru')

@section('content')

    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800">
                        Tambah Siswa Baru
                    </h2>

                    <a href="{{ route('admin.students.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- LEFT COLUMN --}}
                        <div class="space-y-4">

                            {{-- NIS --}}
                            <div>
                                <label for="nis" class="block text-sm font-medium">NIS</label>
                                <input id="nis" type="text" name="nis" value="{{ old('nis') }}" required
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('nis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-medium">Nama Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div>
                                <label for="password" class="block text-sm font-medium">Password</label>
                                <input id="password" type="password" name="password" required
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm --}}
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium">Konfirmasi
                                    Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium">Telepon</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- RIGHT COLUMN --}}
                        <div class="space-y-4">

                            {{-- Gender --}}
                            <div>
                                <label for="gender" class="block text-sm font-medium">Gender</label>
                                <select id="gender" name="gender" required
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Class --}}
                            <div>
                                <label for="school_class_id" class="block text-sm font-medium">Kelas</label>
                                <select id="school_class_id" name="school_class_id" required
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('school_class_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Birth Date --}}
                            <div>
                                <label for="birth_date" class="block text-sm font-medium">Tanggal Lahir</label>
                                <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('birth_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Parent --}}
                            <div>
                                <label for="parent_id" class="block text-sm font-medium">Orang Tua</label>
                                <select id="parent_id" name="parent_id" required
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Orang Tua</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Photo --}}
                            <div>
                                <label for="photo" class="block text-sm font-medium">Foto</label>
                                <input id="photo" type="file" name="photo" accept="image/*"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('photo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                            </div>

                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="mt-6">
                        <label for="address" class="block text-sm font-medium">Alamat</label>
                        <textarea id="address" name="address" rows="3"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Siswa
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection