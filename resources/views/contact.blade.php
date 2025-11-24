@extends('layouts.guest')

@section('content')

<!-- Kontak & Maps -->
<section class="py-16 px-6 bg-white dark:bg-gray-800">
    <div class="max-w-6xl mx-auto">

        <h1 class="text-4xl font-bold mb-8 text-primary text-center">Kontak Kami</h1>

        <div class="max-w-4xl mx-auto space-y-10 text-gray-700 dark:text-gray-300">

            {{-- Success Message --}}
            @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg shadow">
                {{ session('success') }}
            </div>
            @endif

            <!-- FORM -->
            <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- SUBJEK -->
                <div>
                    <label class="block mb-1 font-semibold">Subjek</label>
                    <select name="subject"
                        class="w-full rounded border border-gray-300 bg-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Pilih Subjek</option>
                        <option value="Pertanyaan" {{ old('subject')=='Pertanyaan' ? 'selected' : '' }}>Pertanyaan</option>
                        <option value="Keluhan" {{ old('subject')=='Keluhan' ? 'selected' : '' }}>Keluhan</option>
                        <option value="Saran" {{ old('subject')=='Saran' ? 'selected' : '' }}>Saran</option>
                        <option value="Lainnya" {{ old('subject')=='Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('subject')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NO HP -->
                <div>
                    <label class="block mb-1 font-semibold">No Hp</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full rounded border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary" />
                    @error('phone')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NAMA -->
                <div>
                    <label class="block mb-1 font-semibold">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full rounded border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary" />
                    @error('name')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full rounded border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="example@gmail.com" />
                    @error('email')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PESAN -->
                <div>
                    <label class="block mb-1 font-semibold">Pesan</label>
                    <textarea name="message" rows="4"
                        class="w-full rounded border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">{{ old('message') }}</textarea>
                    @error('message')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="bg-primary text-white px-6 py-2 rounded-xl shadow-md hover:bg-primary-dark transition">
                    Kirim Pesan
                </button>

            </form>

            <!-- MAP -->
            <div class="mt-10">
                <h2 class="text-2xl font-semibold mb-4">Lokasi Sekolah</h2>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.7367467052016!2d118.76862091431872!3d-8.045634685971646!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d8b88a1fb3894f7%3A0xfafe05f4608f7949!2sSMAN%201%20Donggo!5e0!3m2!1sen!2sid!4v1695212140840!5m2!1sen!2sid"
                    width="100%" height="400" class="rounded-xl shadow-md" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>
    </div>
</section>

@endsection
