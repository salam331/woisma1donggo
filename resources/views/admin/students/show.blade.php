<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Siswa: {{ $student->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.students.edit', $student) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit Siswa
                </a>
                <a href="{{ route('admin.students.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
                        <!-- Student Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Siswa</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    @if($student->photo)
                                    <img class="flex-shrink-0 h-20 w-20 rounded-full object-cover" src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}">
                                    @else
                                    <div class="flex-shrink-0 h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-xl font-medium text-gray-700">{{ substr($student->name, 0, 1) }}</span>
                                    </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-xl font-medium text-gray-900">{{ $student->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">NIS</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $student->nis }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $student->email }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Telepon</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $student->phone ?? '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $student->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d F Y') : '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $student->class->name ?? '-' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Orang Tua</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $student->parent->name ?? '-' }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                @if($student->address)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $student->address }}</dd>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm text-gray-600 space-y-2">
                                    <p><strong>ID Siswa:</strong> {{ $student->id }}</p>
                                    <p><strong>Dibuat:</strong> {{ $student->created_at->format('d F Y H:i') }}</p>
                                    <p><strong>Terakhir Update:</strong> {{ $student->updated_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Aksi Cepat</h4>
                                <div class="space-y-2">
                                    <a href="{{ route('admin.students.edit', $student) }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Edit Informasi Siswa
                                    </a>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Lihat Nilai Raport
                                    </button>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Lihat Absensi
                                    </button>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Lihat Tagihan
                                    </button>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-red-700 bg-white border border-red-300 rounded-md hover:bg-red-50">
                                        Nonaktifkan Akun
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
