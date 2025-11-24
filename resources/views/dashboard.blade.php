@extends('layouts.guest')

@section('content')

<!-- Hero section -->
<section class="bg-primary text-white py-20 px-6">
  <div class="max-w-7xl mx-auto text-center">
    <h1 class="text-4xl md:text-6xl font-bold mb-6">Selamat Datang di Sistem Administrasi SMAN 1 Donggo</h1>
    <p class="mb-8 text-lg md:text-xl">Mengoptimalkan manajemen sekolah melalui sistem berbasis web modern dan responsif.</p>
    <a href="#profil-sekolah" class="inline-block bg-white text-primary font-semibold rounded-xl px-8 py-3 hover:bg-gray-100 transition">Lihat Profil Sekolah</a>
  </div>
</section>

<!-- Visi dan Misi -->
<section class="py-16 px-6 bg-gray-50 dark:bg-gray-900">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-3xl font-semibold mb-8 text-primary">Visi dan Misi</h2>
    <div class="grid md:grid-cols-2 gap-12 text-gray-700 dark:text-gray-300">
      <div>
        <h3 class="text-2xl font-semibold mb-4">Visi</h3>
        <p>Menjadi sekolah unggulan dalam pengembangan karakter dan akademik siswa yang berdaya saing global.</p>
      </div>
      <div>
        <h3 class="text-2xl font-semibold mb-4">Misi</h3>
        <ul class="list-disc list-inside space-y-2">
          <li>Menyelenggarakan pembelajaran berkualitas dan inovatif.</li>
          <li>Membentuk karakter siswa yang religius, nasionalis, dan mandiri.</li>
          <li>Memberdayakan potensi siswa melalui kegiatan ekstrakurikuler.</li>
          <li>Meningkatkan profesionalisme tenaga pendidik dan kependidikan.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Keunggulan Sekolah -->
<section id="profil-sekolah" class="py-16 px-6">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-3xl font-semibold mb-10 text-primary">Keunggulan Sekolah</h2>
    <div class="grid md:grid-cols-4 gap-8 text-gray-700 dark:text-gray-300">
      <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-16 w-16 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 14l9-5-9-5-9 5 9 5z" /></svg>
        <h3 class="font-semibold text-xl mb-2">Fasilitas Lengkap</h3>
        <p>Kelengkapan sarana dan prasarana yang mendukung proses belajar mengajar secara optimal.</p>
      </div>
      <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-16 w-16 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 14l9-5-9-5-9 5 9 5z" /></svg>
        <h3 class="font-semibold text-xl mb-2">Guru Kompeten</h3>
        <p>Tim pengajar profesional dan berpengalaman yang mendukung perkembangan akademik siswa.</p>
      </div>
      <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-16 w-16 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 14l9-5-9-5-9 5 9 5z" /></svg>
        <h3 class="font-semibold text-xl mb-2">Kurikulum Berkualitas</h3>
        <p>Kurikulum yang up to date dan relevan dengan kebutuhan zaman dan dunia kerja.</p>
      </div>
      <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-16 w-16 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 14l9-5-9-5-9 5 9 5z" /></svg>
        <h3 class="font-semibold text-xl mb-2">Pendekatan Holistik</h3>
        <p>Mengembangkan potensi akademik dan karakter dengan pendekatan yang seimbang dan menyeluruh.</p>
      </div>
    </div>
  </div>
</section>

@endsection
