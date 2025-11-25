@extends('layouts.app')

@section('title', 'Detail Orang Tua - ' . $parent->name)

@section('content')

<div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">

    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
    <h2 class="font-semibold text-2xl text-gray-800">
        Detail Orang Tua: {{ $parent->name }}
    </h2>

    <div class="flex space-x-3">
        <a href="{{ route('admin.parents.edit', $parent) }}">
            <button
                class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                Edit
            </button>
        </a>
        <a href="{{ route('admin.parents.index') }}">
            <button
                class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                Kembali
            </button>
        </a>
    </div>
</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- ========================================= --}}
            {{--    LEFT PANEL – INFORMASI ORANG TUA       --}}
            {{-- ========================================= --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Orang Tua</h3>

                <div class="flex items-center mb-6">
                    @if($parent->photo)
                        <img class="h-20 w-20 rounded-full object-cover shadow"
                             src="{{ asset('storage/' . $parent->photo) }}">
                    @else
                        <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center shadow">
                            <span class="text-2xl font-bold text-gray-700">
                                {{ substr($parent->name, 0, 1) }}
                            </span>
                        </div>
                    @endif

                    <div class="ml-4">
                        <div class="text-xl font-bold text-gray-900">{{ $parent->name }}</div>
                        <div class="text-sm text-gray-500">{{ $parent->email }}</div>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-800">{{ $parent->email }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-800">{{ $parent->phone ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Hubungan</dt>
                            <dd class="mt-1 text-sm text-gray-800">
                                @if($parent->relationship === 'father') Ayah
                                @elseif($parent->relationship === 'mother') Ibu
                                @else Wali @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jumlah Anak</dt>
                            <dd class="mt-1 text-sm text-gray-800">{{ $parent->students->count() }}</dd>
                        </div>

                    </dl>
                </div>

                @if($parent->address)
                    <div class="mt-6">
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="mt-1 text-sm text-gray-800">{{ $parent->address }}</dd>
                    </div>
                @endif
            </div>


            {{-- ========================================= --}}
            {{--    RIGHT PANEL – INFORMASI ANAK           --}}
            {{-- ========================================= --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Anak</h3>

                @if($parent->students->count() > 0)
                    <div class="space-y-3">

                        @foreach($parent->students as $student)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:bg-gray-100 transition">
                                <div class="flex items-center justify-between">

                                    <div class="flex items-center">
                                        @if($student->photo)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                 src="{{ asset('storage/' . $student->photo) }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ substr($student->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif

                                        <div class="ml-3">
                                            <div class="text-sm font-semibold text-gray-900">{{ $student->name }}</div>
                                            <div class="text-sm text-gray-600">
                                                {{ $student->class->name ?? '-' }} — NIS: {{ $student->nis }}
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ route('admin.students.show', $student) }}"
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Lihat Detail
                                    </a>

                                </div>
                            </div>
                        @endforeach

                    </div>

                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                        <p class="text-gray-500">Belum ada anak yang terdaftar.</p>
                    </div>
                @endif


                {{-- Informasi Tambahan --}}
                <div class="mt-6">
                    <h4 class="text-md font-semibold text-gray-900 mb-2">Informasi Tambahan</h4>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="text-sm text-gray-700 space-y-1">
                            <p><strong>ID Orang Tua:</strong> {{ $parent->id }}</p>
                            <p><strong>Dibuat:</strong> {{ $parent->created_at->format('d F Y H:i') }}</p>
                            <p><strong>Terakhir Update:</strong> {{ $parent->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Aksi Cepat --}}
                <div class="mt-6">
                    <h4 class="text-md font-semibold text-gray-900 mb-3">Aksi Cepat</h4>

                    <div class="space-y-2">

                        <a href="{{ route('admin.parents.edit', $parent) }}">
                            <button
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
                                Edit Informasi Orang Tua
                            </button>
                        </a>

                        <button
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
                            Lihat Tagihan
                        </button>

                        <button
                            class="w-full text-left px-4 py-2 text-sm text-red-700 bg-white border border-red-300 rounded-md hover:bg-red-50 transition">
                            Nonaktifkan Akun
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
