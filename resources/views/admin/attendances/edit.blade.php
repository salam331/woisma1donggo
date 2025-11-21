<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Kehadiran: {{ $attendance->student->name }}
            </h2>
            <a href="{{ route('admin.attendances.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.attendances.update', $attendance) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <!-- Student -->
                                <div>
                                    <label for="student_id" class="block text-sm font-medium text-gray-700">Siswa</label>
                                    <select id="student_id" name="student_id" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Siswa</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ (old('student_id', $attendance->student_id) == $student->id) ? 'selected' : '' }}>
                                            {{ $student->name }} - {{ $student->nis }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Schedule -->
                                <div>
                                    <label for="schedule_id" class="block text-sm font-medium text-gray-700">Jadwal</label>
                                    <select id="schedule_id" name="schedule_id" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Jadwal</option>
                                        @foreach($schedules as $schedule)
                                        <option value="{{ $schedule->id }}" {{ (old('schedule_id', $attendance->schedule_id) == $schedule->id) ? 'selected' : '' }}>
                                            {{ $schedule->subject->name ?? '-' }} - {{ $schedule->class->name ?? '-' }} - {{ $schedule->day }} {{ $schedule->start_time }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('schedule_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date -->
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                                    <input id="date" type="date" name="date" value="{{ old('date', $attendance->date->format('Y-m-d')) }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status Kehadiran</label>
                                    <select id="status" name="status" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Status</option>
                                        <option value="present" {{ (old('status', $attendance->status) == 'present') ? 'selected' : '' }}>Hadir</option>
                                        <option value="absent" {{ (old('status', $attendance->status) == 'absent') ? 'selected' : '' }}>Tidak Hadir</option>
                                        <option value="late" {{ (old('status', $attendance->status) == 'late') ? 'selected' : '' }}>Terlambat</option>
                                        <option value="excused" {{ (old('status', $attendance->status) == 'excused') ? 'selected' : '' }}>Izin</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                    <textarea id="notes" name="notes" rows="4"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes', $attendance->notes) }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Kehadiran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
