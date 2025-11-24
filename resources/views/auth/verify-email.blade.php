<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">

            <div class="flex justify-center mb-6">
                <img class="w-auto h-12" src="https://merakiui.com/images/logo.svg" alt="Logo">
            </div>

            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 text-center">
                Verifikasi Email Anda
            </h2>

            <p class="mt-3 text-gray-600 dark:text-gray-300 text-center text-sm">
                Terima kasih telah mendaftar! Silakan klik tautan yang kami kirim ke email Anda untuk memverifikasi akun.
                Jika Anda tidak menerima email, kami dapat mengirimkan yang baru.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mt-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg text-sm text-center">
                    Link verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif

            <div class="mt-6 flex flex-col space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold py-2 rounded-lg transition">
                        Keluar / Log Out
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
