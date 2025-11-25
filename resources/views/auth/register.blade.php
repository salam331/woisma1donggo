@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4">

    <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 lg:max-w-4xl">

        {{-- Gambar kiri --}}
        <div class="hidden bg-cover lg:block lg:w-1/2"
            style="background-image: url('https://images.unsplash.com/photo-1606660265514-358ebbadc80d?auto=format&fit=crop&w=1575&q=80');">
        </div>

        {{-- Form --}}
        <div class="w-full px-6 py-8 md:px-8 lg:w-1/2">

            {{-- Logo --}}
            <div class="flex justify-center mx-auto">
                {{-- <x-application-logo class="w-auto h-10 text-primary" /> --}}
            </div>

            <p class="mt-3 text-xl text-center text-gray-600 dark:text-gray-200">
                Buat Akun Baru
            </p>

            {{-- Pembatas --}}
            <div class="flex items-center justify-between mt-4">
                <span class="w-1/5 border-b dark:border-gray-600 lg:w-1/4"></span>

                <span class="text-xs text-center text-gray-500 uppercase dark:text-gray-400">
                    daftar dengan email
                </span>

                <span class="w-1/5 border-b dark:border-gray-600 lg:w-1/4"></span>
            </div>

            {{-- FORM REGISTER --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="name">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg 
                        dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600
                        focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-40" />

                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg
                        dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600
                        focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-40" />

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg
                        dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600
                        focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-40" />

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="password_confirmation">
                        Konfirmasi Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg
                        dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600
                        focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-40" />
                </div>

                {{-- Tombol --}}
                <div class="mt-6">
                    <button type="submit"
                        class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize
                        bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none
                        focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                        Daftar
                    </button>
                </div>
            </form>

            {{-- Footer --}}
            <div class="flex items-center justify-between mt-6">
                <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>

                <a href="{{ route('login') }}"
                    class="text-xs text-gray-500 uppercase dark:text-gray-400 hover:underline">
                    sudah punya akun?
                </a>

                <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>
            </div>

        </div>
    </div>

</div>
@endsection
