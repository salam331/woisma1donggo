@extends('layouts.guest')

@section('content')

  <!-- HERO SECTION -->
  <section
    class="relative bg-gradient-to-br from-blue-600 to-blue-400 dark:from-gray-900 dark:to-gray-800 py-24 px-6 overflow-hidden mt-24">
    <div class="absolute inset-0 opacity-20 bg-cover bg-center"
      style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200');"></div>

    <div class="relative max-w-4xl mx-auto text-center text-white">
      <h1 class="text-4xl md:text-5xl font-extrabold drop-shadow-lg">
        Informasi Akademik
      </h1>
      <p class="mt-4 text-lg md:text-xl text-blue-100 dark:text-gray-300">
        Temukan jadwal, kalender akademik, serta informasi penting terkait kegiatan belajar di SMAN 1 Donggo.
      </p>
    </div>
  </section>

  <!-- CONTENT SECTION -->
  <section class="py-16 px-6 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-6xl mx-auto">

      <!-- GRID CARDS -->
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">

        <!-- Card 1: Jadwal Pelajaran -->
        {{-- <div onclick="openModal('modalJadwal')"
          class="group p-6 cursor-pointer rounded-2xl shadow-lg bg-white dark:bg-gray-800 border hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900 mx-auto">
            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24">
              <path d="M8 6V4h8v2m4 0H4m16 0v12H4V6m4 0h8" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mt-6 text-center text-gray-800 dark:text-gray-100">Jadwal Pelajaran</h3>
          <p class="mt-2 text-center text-gray-600 dark:text-gray-400">Lihat jadwal pelajaran terbaru setiap semester.</p>
        </div> --}}

        <!-- Card 2: Kalender Akademik -->
        <div onclick="openModal('modalKalender')"
          class="group p-6 cursor-pointer rounded-2xl shadow-lg bg-white dark:bg-gray-800 border hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-green-100 dark:bg-green-900 mx-auto">
            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24">
              <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mt-6 text-center text-gray-800 dark:text-gray-100">Kalender Akademik</h3>
          <p class="mt-2 text-center text-gray-600 dark:text-gray-400">Informasi penting tentang libur, ujian, dan
            kegiatan sekolah.</p>
        </div>

        <!-- Card 3: Pengumuman -->
        <div onclick="openModal('modalPengumuman')"
          class="group p-6 cursor-pointer rounded-2xl shadow-lg bg-white dark:bg-gray-800 border hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-yellow-100 dark:bg-yellow-900 mx-auto">
            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24">
              <path d="M13 16h-1v-4h-1m1-4h.01M12 6a9 9 0 100 18 9 9 0 000-18z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mt-6 text-center text-gray-800 dark:text-gray-100">Pengumuman Akademik</h3>
          <p class="mt-2 text-center text-gray-600 dark:text-gray-400">Informasi terbaru terkait kebijakan dan kegiatan
            sekolah.</p>
        </div>

        <!-- Card 4: Informasi Ujian -->
        <div onclick="openModal('modalUjian')"
          class="group p-6 cursor-pointer rounded-2xl shadow-lg bg-white dark:bg-gray-800 border hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-red-100 dark:bg-red-900 mx-auto">
            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24">
              <path d="M12 12v4m0-8h.01M3 6h18M4 6l1.54 12.37A2 2 0 007.52 20h8.96a2 2 0 002-1.63L20 6H4z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold mt-6 text-center text-gray-800 dark:text-gray-100">Informasi Ujian</h3>
          <p class="mt-2 text-center text-gray-600 dark:text-gray-400">Detail lengkap pelaksanaan ujian sekolah dan
            nasional.</p>
        </div>

      </div>

      <div class="max-w-4xl mx-auto text-center mt-16 text-gray-700 dark:text-gray-300">
        <p class="text-lg">
          Halaman ini akan terus diperbarui dengan informasi akademik terbaru untuk siswa dan orang tua.
        </p>
      </div>

    </div>
  </section>


  <!-- ===================================================== -->
  <!-- ====================== MODALS ======================== -->
  <!-- ===================================================== -->

  <!-- Modal Jadwal -->
  {{-- <div id="modalJadwal" class="modal fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-11/12 md:w-1/2 relative">
      <button onclick="closeModal('modalJadwal')" class="absolute top-3 right-3 text-xl">✖</button>
      <h2 class="text-2xl font-bold mb-4">Jadwal Pelajaran</h2>
      <p>Berikut adalah jadwal pelajaran terbaru setiap hari.</p>
    </div>
  </div> --}}

  <!-- Modal Kalender -->
  <div id="modalKalender" class="modal fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-11/12 md:w-1/2 relative">
      <button onclick="closeModal('modalKalender')" class="absolute top-3 right-3 text-xl">✖</button>
      <h2 class="text-2xl font-bold mb-4">Kalender Akademik 2024/2025</h2>
      <p>Berikut kalender akademik lengkap tahun ajaran 2024/2025.</p>
    </div>
  </div>

  <!-- Modal Pengumuman -->
  <div id="modalPengumuman" class="modal fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-11/12 md:w-1/2 relative">
      <button onclick="closeModal('modalPengumuman')" class="absolute top-3 right-3 text-xl">✖</button>
      <h2 class="text-2xl font-bold mb-4">Pengumuman Akademik</h2>
      <p>Berikut pengumuman terbaru terkait kebijakan sekolah.</p>
    </div>
  </div>

  <!-- Modal Ujian -->
  <div id="modalUjian" class="modal fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-11/12 md:w-1/2 relative">
      <button onclick="closeModal('modalUjian')" class="absolute top-3 right-3 text-xl">✖</button>
      <h2 class="text-2xl font-bold mb-4">Informasi Ujian</h2>
      <p>Berikut informasi lengkap seputar ujian sekolah dan ujian nasional.</p>
    </div>
  </div>


  <!-- SCRIPT -->
  <script>
    function openModal(id) {
      document.getElementById(id).classList.remove('hidden');
      document.getElementById(id).classList.add('flex');
    }

    function closeModal(id) {
      document.getElementById(id).classList.add('hidden');
      document.getElementById(id).classList.remove('flex');
    }

    // Tutup modal jika klik area gelap
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('modal')) {
        e.target.classList.add('hidden');
        e.target.classList.remove('flex');
      }
    });
  </script>

@endsection