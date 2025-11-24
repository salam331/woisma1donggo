@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        <h2 class="text-3xl font-bold text-gray-800 text-center">Reset Password</h2>
        <p class="mt-2 text-gray-600 text-center text-sm">
            Masukkan password baru Anda.
        </p>

        <form method="POST" action="{{ route('password.update') }}" class="mt-6">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            
            {{-- Email --}}
            <label class="block mb-3">
                <span class="text-gray-700 font-semibold">Email</span>
                <input 
                    type="email" 
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    class="mt-1 w-full px-4 py-2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                >
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </label>

            {{-- Password Baru --}}
            <label class="block mb-3">
                <span class="text-gray-700 font-semibold">Password Baru</span>
                <input 
                    type="password" 
                    name="password"
                    required
                    class="mt-1 w-full px-4 py-2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                >
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </label>

            {{-- Konfirmasi Password --}}
            <label class="block mb-3">
                <span class="text-gray-700 font-semibold">Konfirmasi Password</span>
                <input 
                    type="password" 
                    name="password_confirmation"
                    required
                    class="mt-1 w-full px-4 py-2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                >
            </label>

            <button 
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition"
            >
                Reset Password
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">
                Kembali ke Login
            </a>
        </div>
    </div>
</div>
@endsection
