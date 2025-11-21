<x-publik-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kontak Kami') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-4">Hubungi Kami</h1>
                    <p class="text-lg mb-6">Jika Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut, jangan ragu untuk menghubungi kami.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h2 class="text-2xl font-semibold mb-4">Informasi Kontak</h2>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Alamat</p>
                                        <p>Jl. Pendidikan No. 1, Donggo, Indonesia</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Telepon</p>
                                        <p>(021) 1234-5678</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Email</p>
                                        <p>info@sman1donggo.sch.id</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-2xl font-semibold mb-4">Kirim Pesan</h2>
                            <form class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                                    <textarea id="message" name="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>

                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-publik-layout>
