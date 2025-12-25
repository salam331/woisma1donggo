@extends('layouts.app')

@section('title', 'Pengumuman')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Pengumuman</h1>
                </div>

                @if($announcements->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengumuman</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada pengumuman yang tersedia.</p>
                    </div>
                @else
                    <!-- Desktop Table View -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Publikasi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($announcements as $announcement)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $announcement->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($announcement->publish_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ ucfirst($announcement->target) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{-- <button onclick="openModal({{ $announcement->id }})"
                                                    class="text-blue-600 hover:text-blue-900">
                                                Lihat Detail
                                            </button> --}}
                                            {{-- gunakan icon mata untuk membuka modal detail --}}
                                            <button onclick="openModal({{ $announcement->id }})"
                                                    class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($announcements->hasPages())
                        <div class="mt-4">
                            {{ $announcements->links() }}
                        </div>
                        @endif
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden space-y-4">
                        @foreach($announcements as $announcement)
                        <div class="bg-white rounded-lg shadow-sm border p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $announcement->title }}</h3>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst($announcement->target) }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($announcement->publish_date)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button onclick="openModal({{ $announcement->id }})"
                                        class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                        @endforeach

                        <!-- Mobile Pagination -->
                        @if($announcements->hasPages())
                        <div class="mt-4 flex justify-center">
                            {{ $announcements->links() }}
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal for Announcement Details -->
<div id="announcementModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="modalDate"></p>
                <div class="mt-4 text-sm text-gray-700" id="modalContent"></div>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    // Find the announcement data - in a real app, you'd fetch this via AJAX
    // For now, we'll use a simple approach
    // const announcements = @json($announcements);
    const announcements = @json($announcements->items());
    const announcement = announcements.find(a => a.id === id);

    if (announcement) {
        document.getElementById('modalTitle').textContent = announcement.title;
        document.getElementById('modalDate').textContent = new Date(announcement.publish_date).toLocaleDateString('id-ID');
        document.getElementById('modalContent').innerHTML = announcement.content;
        document.getElementById('announcementModal').classList.remove('hidden');
    }
}

function closeModal() {
    document.getElementById('announcementModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('announcementModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection
