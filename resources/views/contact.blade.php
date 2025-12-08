@extends('layouts.guest')

@section('content')

    <section class="py-16 px-6 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto">

            <h1 class="text-4xl font-bold mb-12 text-primary text-center">
                Kontak Kami
            </h1>

            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="max-w-3xl mx-auto mb-6 bg-green-100 text-green-700 p-4 rounded-lg shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- GRID 2 KOLOM -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <div class="bg-gray-50 dark:bg-gray-900 p-8 rounded-xl shadow-lg border dark:border-gray-700">
                    <!-- MAPS -->
                    <div>
                        <h2 class="text-2xl font-semibold text-center mb-4 text-gray-800 dark:text-gray-200">
                            Lokasi Sekolah
                        </h2>

                        <div class="rounded-xl overflow-hidden shadow-lg border dark:border-gray-700">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.902444879743!2d118.6055815!3d-8.4269583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dca749685e7eabb%3A0x60ea19c9cc8d0917!2sSMA%20Negeri%201%20Donggo!5e0!3m2!1sid!2sid!4v1733480000000!5m2!1sid!2sid"
                                width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>

                        </div>
                    </div>
                </div>
                <!-- FORM -->
                <div class="bg-gray-50 dark:bg-gray-900 p-8 rounded-xl shadow-lg border dark:border-gray-700">
                    <h2 class="text-2xl font-semibold text-center mb-6 text-gray-800 dark:text-gray-200">
                        Kirim Pesan
                    </h2>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- SUBJEK -->
                        <div>
                            <label class="block mb-1 font-semibold">Subjek</label>
                            <select name="subject"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2 focus:ring-2 focus:ring-primary">
                                <option value="">Pilih Subjek</option>
                                <option value="Pertanyaan" {{ old('subject') == 'Pertanyaan' ? 'selected' : '' }}>Pertanyaan
                                </option>
                                <option value="Keluhan" {{ old('subject') == 'Keluhan' ? 'selected' : '' }}>Keluhan</option>
                                <option value="Saran" {{ old('subject') == 'Saran' ? 'selected' : '' }}>Saran</option>
                                <option value="Lainnya" {{ old('subject') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('subject') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- NO HP -->
                        <div>
                            <label class="block mb-1 font-semibold">No Hp</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2 dark:bg-gray-800 focus:ring-2 focus:ring-primary" />
                            @error('phone') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- NAMA -->
                        <div>
                            <label class="block mb-1 font-semibold">Nama</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2 dark:bg-gray-800 focus:ring-2 focus:ring-primary" />
                            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <label class="block mb-1 font-semibold">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2 dark:bg-gray-800 focus:ring-2 focus:ring-primary"
                                placeholder="example@gmail.com" />
                            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- PESAN -->
                        <div>
                            <label class="block mb-1 font-semibold">Pesan</label>
                            <textarea name="message" rows="4"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2 dark:bg-gray-800 focus:ring-2 focus:ring-primary">{{ old('message') }}</textarea>
                            @error('message') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit"
                            class="bg-primary text-white w-full py-3 rounded-xl shadow-md hover:bg-primary-dark transition">
                            Kirim Pesan
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </section>

@endsection