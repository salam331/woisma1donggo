{{-- resources/views/admin/teachers/show.blade.php --}}
@extends('layouts.app') {{-- app.blade.php --}}

@section('title', 'Detail Guru: ' . $teacher->name)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Teacher Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Guru</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                @if($teacher->photo)
                                <img class="flex-shrink-0 h-20 w-20 rounded-full object-cover" src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}">
                                @else
                                <div class="flex-shrink-0 h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-xl font-medium text-gray-700">{{ substr($teacher->name, 0, 1) }}</span>
                                </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-xl font-medium text-gray-900">{{ $teacher->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $teacher->email }}</div>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">NIP</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->nip }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Telepon</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->phone ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->birth_date ? \Carbon\Carbon::parse($teacher->birth_date)->format('d F Y') : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Spesialisasi</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $teacher->subject_specialization ?? '-' }}</dd>
                                    </div>
                                </dl>
                            </div>

                            @if($teacher->address)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $teacher->address }}</dd>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm text-gray-600 space-y-2">
                                <p><strong>ID Guru:</strong> {{ $teacher->id }}</p>
                                <p><strong>Dibuat:</strong> {{ $teacher->created_at->format('d F Y H:i') }}</p>
                                <p><strong>Terakhir Update:</strong> {{ $teacher->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Aksi Cepat</h4>
                            <div class="space-y-2">
                                <a href="{{ route('admin.teachers.edit', $teacher) }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Edit Informasi Guru
                                </a>
                                <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Lihat Jadwal Mengajar
                                </button>
                                <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Lihat Materi yang Dibuat
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
@endsection
