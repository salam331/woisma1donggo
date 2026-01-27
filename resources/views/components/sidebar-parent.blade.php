<aside
    class="flex flex-col w-64 h-screen bg-white dark:bg-gray-900 border-r dark:border-gray-700 sticky top-0">

    {{-- HEADER --}}
    <div class="flex items-center px-6 py-6 border-b dark:border-gray-700">
        <span class="text-lg font-bold text-gray-700 dark:text-gray-200">
            Parent Panel
        </span>
    </div>

    {{-- MENU --}}
    <nav class="flex flex-col flex-1 py-4 space-y-1 overflow-y-auto">

        {{-- ================= DASHBOARD ================= --}}
        <a href="{{ route('orang_tua.dashboard') }}"
           class="relative flex items-center px-4 py-2 space-x-3 rounded transition
           {{ request()->routeIs('orang_tua.dashboard')
                ? 'text-blue-600 font-semibold'
                : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">

            @if(request()->routeIs('orang_tua.dashboard'))
                <span class="absolute left-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-5 h-5" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l9-9 9 9M4 10v10h6V14h4v6h6V10" />
            </svg>

            <span>Dashboard</span>
        </a>

        {{-- ================= PENGUMUMAN ================= --}}
        <a href="{{ url('/orang_tua/announcements') }}"
           class="relative flex items-center px-4 py-2 space-x-3 rounded transition
           {{ request()->is('orang_tua/announcements*')
                ? 'text-blue-600 font-semibold'
                : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">

            @if(request()->is('orang_tua/announcements*'))
                <span class="absolute left-0 h-full w-1 bg-blue-600 rounded"></span>
            @endif

            <svg class="w-5 h-5" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5l7 7-7 7" />
            </svg>

            <span>Pengumuman</span>
        </a>

        {{-- ================= INFORMASI ANAK (DROPDOWN) ================= --}}
        <div x-data="{ open: false }" class="mt-2">

            {{-- HEADER DROPDOWN --}}
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-2 text-gray-700 dark:text-gray-300
                       hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition">

                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5V10H2v10h5m10 0V4a2 2 0 00-2-2H9a2 2 0 00-2 2v16" />
                    </svg>
                    <span class="font-medium">Informasi Anak</span>
                </div>

                <svg class="w-4 h-4 transform transition"
                     :class="open ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- ISI DROPDOWN --}}
            <div x-show="open" x-transition class="mt-1 space-y-1 pl-6">

                @if(auth()->user()->parent && auth()->user()->parent->students->count() > 0)

                    @foreach(auth()->user()->parent->students as $child)

                        {{-- NAMA ANAK --}}
                        <div class="text-sm text-gray-500 font-semibold mt-3">
                            {{ $child->user->name }}
                        </div>

                        {{-- DETAIL --}}
                        <a href="{{ url('/orang_tua/child/detail', $child->id) }}"
                           class="relative flex items-center px-3 py-2 rounded text-sm transition
                           {{ request()->routeIs('parent.child.detail') && request()->route('childId') == $child->id
                                ? 'text-blue-600 font-semibold'
                                : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                            Detail Anak
                        </a>

                        {{-- KEHADIRAN --}}
                        <a href="{{ url('/orang_tua/child/attendance', $child->id) }}"
                           class="relative flex items-center px-3 py-2 rounded text-sm transition
                           {{ request()->routeIs('parent.child.attendance') && request()->route('childId') == $child->id
                                ? 'text-blue-600 font-semibold'
                                : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                            Kehadiran
                        </a>

                        {{-- TAGIHAN --}}
                        <a href="{{ url('/orang_tua/child/invoices', $child->id) }}"
                           class="relative flex items-center px-3 py-2 rounded text-sm transition
                           {{ request()->routeIs('parent.child.invoices') && request()->route('childId') == $child->id
                                ? 'text-blue-600 font-semibold'
                                : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                            Tagihan
                        </a>

                    @endforeach

                @else
                    {{-- KONDISI ELSE --}}
                    <div class="px-3 py-2 text-sm text-gray-400 italic">
                        Belum ada data anak terdaftar
                    </div>
                @endif

            </div>
        </div>

    </nav>
</aside>
