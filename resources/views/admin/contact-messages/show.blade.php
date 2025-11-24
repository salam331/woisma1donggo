<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesan Kontak
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Nama:</h3>
                    <p>{{ $contactMessage->name }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Email:</h3>
                    <p>{{ $contactMessage->email }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">No Hp:</h3>
                    <p>{{ $contactMessage->phone }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Subjek:</h3>
                    <p>{{ $contactMessage->subject }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Pesan:</h3>
                    <p>{{ $contactMessage->message }}</p>
                </div>

                <form method="POST" action="{{ route('admin.contact-messages.update', $contactMessage->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_read" value="1" {{ $contactMessage->is_read ? 'checked' : '' }}>
                            <span class="ml-2">Sudah Dibaca</span>
                        </label>
                    </div>
                    <div class="mb-4">
                        <label for="admin_feedback" class="block text-sm font-medium text-gray-700">Feedback Admin</label>
                        <textarea id="admin_feedback" name="admin_feedback" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('admin_feedback', $contactMessage->admin_feedback) }}</textarea>
                    </div>
                    <div class="space-x-4">
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-white shadow-sm hover:bg-indigo-700">
                            Simpan
                        </button>
                        <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm hover:bg-gray-50">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
