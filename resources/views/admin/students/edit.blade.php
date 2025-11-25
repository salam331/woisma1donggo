@extends('layouts.app')

@section('title', 'Edit Siswa: ' . $student->name)

@section('content')

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                        Edit Siswa: {{ $student->name }}
                    </h2>
                    <a href="{{ route('admin.students.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.students.update', $student) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- LEFT COLUMN --}}
                        <div class="space-y-4">

                            {{-- NIS --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIS</label>
                                <input id="nis" type="text" name="nis" value="{{ old('nis', $student->nis) }}" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                               rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('nis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                    Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $student->name) }}" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                                  rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $student->email) }}"
                                    required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                                  rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone', $student->phone) }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                                  rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Gender --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                                <select id="gender" name="gender" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                                   rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Gender</option>
                                    <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- RIGHT COLUMN --}}
                        <div class="space-y-4">

                            {{-- Class --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                                <select id="class_id" name="class_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                                   rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Birth Date --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                    Lahir</label>
                                <input id="birth_date" type="date" name="birth_date"
                                    value="{{ old('birth_date', $student->birth_date?->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                                  rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('birth_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Parent --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Orang Tua</label>
                                <select id="parent_id" name="parent_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                                   rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Orang Tua</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $student->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Current Photo --}}
                            @if($student->photo)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Saat
                                        Ini</label>
                                    <img src="{{ asset('storage/' . $student->photo) }}"
                                        class="h-20 w-20 rounded-full object-cover mt-1">
                                </div>
                            @endif

                            {{-- Upload Photo --}}
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $student->photo ? 'Ganti Foto' : 'Foto' }}
                                </label>
                                <input id="photo" type="file" name="photo" accept="image/*" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                                  rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <p class="mt-1 text-sm text-gray-500">
                                    Format: JPG, PNG, GIF — Max 2MB.
                                    {{ $student->photo ? 'Biarkan kosong jika tidak ingin mengubah foto.' : '' }}
                                </p>
                                @error('photo')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                        <textarea id="address" name="address" rows="3"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700
                                             rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('address', $student->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Siswa
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection