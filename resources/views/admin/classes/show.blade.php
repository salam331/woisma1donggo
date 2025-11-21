<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Kelas: {{ $class->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.classes.edit', $class) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit Kelas
                </a>
                <a href="{{ route('admin.classes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
                        <!-- Class Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kelas</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-2xl font-bold text-blue-600">{{ substr($class->name, 0, 2) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-2xl font-medium text-gray-900">{{ $class->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $class->grade_level }}</div>
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Nama Kelas</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $class->name }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tingkat</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $class->grade_level }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Wali Kelas</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $class->teacher ? $class->teacher->name : '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Jumlah Siswa</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $class->students->count() }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                @if($class->description)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $class->description }}</dd>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Students in Class -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Siswa ({{ $class->students->count() }})</h3>
                            @if($class->students->count() > 0)
                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach($class->students as $student)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            @if($student->photo)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}">
                                            @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">{{ substr($student->name, 0, 1) }}</span>
                                            </div>
                                            @endif
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                                <div class="text-sm text-gray-500">NIS: {{ $student->nis }}</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.students.show', $student) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="bg-gray-50 rounded-lg p-4 text-center">
                                <p class="text-gray-500">Belum ada siswa yang terdaftar di kelas ini.</p>
                            </div>
                            @endif

                            <!-- Additional Information -->
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Informasi Tambahan</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="text-sm text-gray-600 space-y-2">
                                        <p><strong>ID Kelas:</strong> {{ $class->id }}</p>
                                        <p><strong>Dibuat:</strong> {{ $class->created_at->format('d F Y H:i') }}</p>
                                        <p><strong>Terakhir Update:</strong> {{ $class->updated_at->format('d F Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Aksi Cepat</h4>
                                <div class="space-y-2">
                                    <a href="{{ route('admin.classes.edit', $class) }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Edit Informasi Kelas
                                    </a>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Lihat Jadwal Pelajaran
                                    </button>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Lihat Absensi Kelas
                                    </button>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-red-700 bg-white border border-red-300 rounded-md hover:bg-red-50">
                                        Hapus Kelas
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
