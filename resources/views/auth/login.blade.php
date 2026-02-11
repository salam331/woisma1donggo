@extends('layouts.guest')

@section('content')

<div class="min-h-screen flex items-center justify-center 
            bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-700 
            px-4 relative overflow-hidden mt-12">

    <!-- Glow Effect Background -->
    <div class="absolute w-96 h-96 bg-white opacity-10 rounded-full blur-3xl top-10 left-10"></div>
    <div class="absolute w-96 h-96 bg-white opacity-10 rounded-full blur-3xl bottom-10 right-10"></div>

    <div class="relative flex w-full max-w-5xl mx-auto overflow-hidden 
                bg-white/90 backdrop-blur-xl rounded-2xl shadow-2xl">

        <!-- LEFT SIDE (LOGO SECTION) -->
        <div class="hidden lg:flex lg:w-1/2 
                    items-center justify-center 
                    bg-gradient-to-br from-blue-500 to-indigo-600 
                    text-white p-10">

            <div class="text-center space-y-6">
                <img src="{{ asset('images/logo.png') }}"
                    alt="Logo SMAN 1 Donggo"
                    class="w-48 mx-auto drop-shadow-xl">

                <h2 class="text-2xl font-bold tracking-wide">
                    SMAN 1 Donggo
                </h2>

                <p class="text-sm opacity-90 leading-relaxed">
                    Sistem Informasi Sekolah Terintegrasi
                </p>
            </div>
        </div>

        <!-- RIGHT SIDE (FORM) -->
        <div class="w-full lg:w-1/2 px-8 py-12">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Selamat Datang
                </h1>
                <p class="text-gray-500 text-sm mt-2">
                    Silakan masuk untuk melanjutkan
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-1">
                        Email
                    </label>

                    <input id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        required autofocus autocomplete="username"
                        placeholder="example@gmail.com"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 
                               focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                               transition duration-200 outline-none"/>

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="text-sm font-semibold text-gray-600">
                            Password
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-xs text-blue-600 hover:underline">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <input id="password" type="password" name="password"
                        required autocomplete="current-password"
                        placeholder="Masukkan password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300
                               focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                               transition duration-200 outline-none"/>

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- REMEMBER -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                        <span class="ml-2">Ingat saya</span>
                    </label>
                </div>

                <!-- BUTTON -->
                <div>
                    <button type="submit"
                        class="w-full py-3 rounded-xl text-white font-semibold
                               bg-gradient-to-r from-blue-600 to-indigo-700
                               hover:from-blue-700 hover:to-indigo-800
                               shadow-lg hover:shadow-xl
                               transition duration-300">
                        Masuk
                    </button>
                </div>
            </form>

            <!-- FOOTER -->
            @if (Route::has('register'))
            <div class="text-center mt-8 text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="text-blue-600 font-semibold hover:underline">
                    Daftar sekarang
                </a>
            </div>
            @endif

        </div>
    </div>
</div>

@endsection