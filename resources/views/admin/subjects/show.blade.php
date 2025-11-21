<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Mata Pelajaran: {{ $subject->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.subjects.edit', $subject) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit Mata Pelajaran
                </a>
                <a href="{{ route('admin.subjects.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Subject Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Mata Pelajaran</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 bg-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-2xl font-bold text-green-600">{{ substr($subject->code, 0, 2) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-2xl font-medium text-gray-900">{{ $subject->name }}</div>
                                        <div class="text-sm text-gray-500">Kode: {{ $subject->code }}</div>
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Nama Mata Pelajaran</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $subject->name }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Kode</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $subject->code }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Guru Pengajar</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $subject->teacher ? $subject->teacher->name : '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Jumlah Jadwal</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $subject->schedules->count() }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                @if($subject->description)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $subject->description }}</dd>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Schedules Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Jadwal Pelajaran ({{ $subject->schedules->count() }})</h3>
                            @if($subject->schedules->count() > 0)
                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach($subject->schedules as $schedule)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-600">{{ substr($schedule->class->name ?? 'N/A', 0, 2) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $schedule->class->name ?? 'Kelas Tidak Ditemukan' }}</div>
                                                <div class="text-sm text-gray-500">{{ $schedule->day }} - {{ $schedule->start_time }} sampai {{ $schedule->end_time }}</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.schedules.show', $schedule) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-gray-500">Belum ada jadwal pelajaran untuk mata pelajaran ini.</p>
                            </div>
                            @endif

                            <!-- Additional Information -->
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Informasi Tambahan</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-600 space-y-2">
                                        <p><strong>ID Mata Pelajaran:</strong> {{ $subject->id }}</p>
                                        <p><strong>Dibuat:</strong> {{ $subject->created_at->format('d F Y H:i') }}</p>
                                        <p><strong>Terakhir Update:</strong> {{ $subject->updated_at->format('d F Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Aksi Cepat</h4>
                                <div class="space-y-2">
                                    <a href="{{ route('admin.subjects.edit', $subject) }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Edit Informasi Mata Pelajaran
                                    </a>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Lihat Materi Pelajaran
                                    </button>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Lihat Nilai Siswa
                                    </button>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-red-700 bg-white border border-red-300 rounded-md hover:bg-red-50">
                                        Hapus Mata Pelajaran
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
