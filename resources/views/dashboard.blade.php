<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @hasrole('admin')
                        {{ __("Welcome to Admin Dashboard!") }}
                    @endhasrole
                    @hasrole('guru')
                        {{ __("Welcome to Guru Dashboard!") }}
                    @endhasrole
                    @hasrole('siswa')
                        {{ __("Welcome to Siswa Dashboard!") }}
                    @endhasrole
                    @hasrole('orang_tua')
                        {{ __("Welcome to Orang Tua Dashboard!") }}
                    @endhasrole
                    @hasrole('publik')
                        {{ __("Welcome to Publik Dashboard!") }}
                    @endhasrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
