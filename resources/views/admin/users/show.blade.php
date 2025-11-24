@extends('layouts.app')

@section('title', 'Detail Pengguna: ' . $user->name)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- User Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pengguna</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-16 w-16">
                                    <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-xl font-medium text-gray-700">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-xl font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Role</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                                {{ $role->name }}
                                            </span>
                                            @endforeach
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Bergabung Sejak</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d F Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Terakhir Update</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d F Y H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm text-gray-600">
                                <p class="mb-2"><strong>ID Pengguna:</strong> {{ $user->id }}</p>
                                <p class="mb-2"><strong>Email Terverifikasi:</strong>
                                    @if($user->email_verified_at)
                                    <span class="text-green-600">Ya</span>
                                    @else
                                    <span class="text-red-600">Tidak</span>
                                    @endif
                                </p>
                                <p><strong>Total Login:</strong> -</p>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Aksi Cepat</h4>
                            <div class="space-y-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Edit Informasi Pengguna
                                </a>
                                <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Reset Password
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
