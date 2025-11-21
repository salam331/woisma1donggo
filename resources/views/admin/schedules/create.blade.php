<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buat Jadwal Baru
            </h2>
            <a href="{{ route('admin.schedules.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('admin.schedules.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Class -->
                            <div>
                                <label for="class_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                                <select id="class_id" name="class_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject_id" class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                                <select id="subject_id" name="subject_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teacher -->
                            <div>
                                <label for="teacher_id" class="block text-sm font-medium text-gray-700">Guru</label>
                                <select id="teacher_id" name="teacher_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Guru</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Day -->
                            <div>
                                <label for="day" class="block text-sm font-medium text-gray-700">Hari</label>
                                <select id="day" name="day"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Hari</option>
                                    <option value="monday" {{ old('day') == 'monday' ? 'selected' : '' }}>Senin</option>
                                    <option value="tuesday" {{ old('day') == 'tuesday' ? 'selected' : '' }}>Selasa</option>
                                    <option value="wednesday" {{ old('day') == 'wednesday' ? 'selected' : '' }}>Rabu</option>
                                    <option value="thursday" {{ old('day') == 'thursday' ? 'selected' : '' }}>Kamis</option>
                                    <option value="friday" {{ old('day') == 'friday' ? 'selected' : '' }}>Jumat</option>
                                    <option value="saturday" {{ old('day') == 'saturday' ? 'selected' : '' }}>Sabtu</option>
                                    <option value="sunday" {{ old('day') == 'sunday' ? 'selected' : '' }}>Minggu</option>
                                </select>
                                @error('day')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Time -->
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                                <input type="time" id="start_time" name="start_time"
                                    value="{{ old('start_time') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('start_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Time -->
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                                <input type="time" id="end_time" name="end_time"
                                    value="{{ old('end_time') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('end_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                Simpan Jadwal
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
