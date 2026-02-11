KEGAGALAN TERBESAR ADALAH MENGIKHLASKAN CINTA YANG TELAH KITA BANGUN

✅ SISTEM ADMINISTRASI SMAN 1 DONGGO
Teknologi utama:
•	Blade Components
•	TailwindCSS v3 (bukan v4)
•	UI preset MerakiUI
•	Responsive-first (HP → Tablet → Desktop)
•	Clean Architecture (Controller + Service + Repository)
•	Middleware: role-based
•	Sidebar otomatis menyesuaikan role
________________________________________
🟦 Mulai Prompt Utama
Gunakan instruksi berikut untuk membangun website Sistem Administrasi SMAN 1 DONGGO secara lengkap menggunakan Laravel Blade + Tailwind (MerakiUI). Buatkan struktur folder, arsitektur Laravel, contoh kode Blade, komponen Tailwind, migrasi database, seeding, controller, routing, middleware role-based, layout umum, layout khusus, dan desain UI responsif. Semua tampilan wajib mobile-first dan modern sesuai style MerakiUI.
________________________________________
🟩 1. Konsep & Desain Utama
Bangun sistem web dengan karakteristik:
✦ Wajib:
•	UI modern bergaya MerakiUI (https://merakiui.com/)
•	Navigasi responsif:
o	Mobile → hamburger menu + drawer
o	Desktop → sidebar (untuk role), navbar fixed
•	Komponen Blade reusable
•	Dark mode
•	SEO-friendly untuk halaman publik
✦ UI Global (Semua role + halaman publik)
•	Header
•	Footer
•	Mobile navbar
•	Global search bar (opsional)
•	Modal umum (confirm, alert, success) yang secara otomatis menghilang selama 2 detik
________________________________________
🟩 2. Halaman Publik
Buat halaman publik dengan desain modern bergaya MerakiUI:
2.1 Beranda
•	Hero section full-width
•	CTA button
•	Visi dan Misi
•	Keunggulan Sekolah (icons)
•	CTA “Lihat Profil Sekolah”
•	Footer modern
2.2 Profil Sekolah
•	Sejarah
•	Guru & Staf (grid cards)
•	Prestasi
•	Fasilitas (gallery grid)
2.3 Informasi Akademik
•	Jurusan
•	Kurikulum
•	Ekstrakurikuler
2.4 Berita & Pengumuman
•	Card grid
•	Pagination
•	Detail berita
2.5 Galeri
•	Gallery foto/video
•	Modal zoom responsive
2.6 Kontak & Maps
•	Form Contact Message
•	Embedded Google Maps
________________________________________
🟩 3. Role dan Fitur Backend
Siapkan middleware + guard untuk 4 role:
admin, teacher, student, parent.
Sidebar menyesuaikan menu berdasarkan role.
________________________________________
🟦 3.1 Role ADMIN
Sidebar item admin:
1.	Dashboard
2.	Users (index + show)
3.	Teachers (CRUD + show)
4.	Students (CRUD + show)
5.	Parents (CRUD + show)
6.	Classes (CRUD + show)
7.	Subjects (CRUD + show)
8.	Materials (CRUD + show)
9.	Schedules (CRUD + show)
10.	Attendances (CRUD + show berdasarkan kelas -> mapel -> siswa -> riwayat absensi + summary dalam modal yang berisi grafik batang)
11.	Invoices (CRUD + show)
________________________________________
🟦 3.2 Role GURU
Sidebar guru:
1.	Dashboard
2.	Classes (lihat daftar siswa & input absensi)
3.	Attendances (CRUD + show)
4.	Schedule (daily/weekly)
5.	Materials (CRUD + show)
6.	Subjects (index + show)
7.	Announcements (index)
8.	Grades (CRUD + show)
9.	Exams (CRUD + input nilai + show)
________________________________________
🟦 3.3 Role SISWA
Sidebar siswa:
1.	Dashboard
2.	Schedule (daily/weekly)
3.	Attendance (show per mapel)
4.	Grades (index)
5.	Materials (index, show, download)
6.	Announcements (index + show)
7.	Invoices (index + show)
________________________________________
🟦 3.4 Role ORANG TUA
Orang tua dapat memiliki lebih dari 1 siswa.
Sidebar orang tua:
1.	Dashboard
2.	Announcements
3.	Detail Siswa (Personal Info, Wali Kelas, Orang Tua)
4.	Attendance (index)
5.	Grades (index)
6.	Invoices (index)
________________________________________
🟩 4. Struktur Layout Blade
Buat komponen Blade berikut:
Global:
/resources/views/components/
  ├── header.blade.php
  ├── footer.blade.php
  ├── mobile-nav.blade.php
  ├── sidebar-admin.blade.php
  ├── sidebar-teacher.blade.php
  ├── sidebar-student.blade.php
  ├── sidebar-parent.blade.php
  ├── card.blade.php
  ├── table.blade.php
  ├── form-input.blade.php
  ├── btn-primary.blade.php
  ├── btn-secondary.blade.php
  └── modal.blade.php
Layout utama:
/resources/views/layouts/
  ├── app.blade.php     (untuk semua role)
  ├── guest.blade.php   (untuk halaman publik)
________________________________________
🟩 5. Tailwind & MerakiUI
Instruksi konfigurasi:
•	Install Tailwind v3 (bukan v4)
•	Integrasikan MerakiUI:
o	copy komponen
o	gunakan warna-warna MerakiUI
•	Buat theme custom di tailwind.config:
Contoh:
extend: {
  colors: {
    primary: "#4f46e5",
    secondary: "#64748b",
  },
  fontFamily: {
    sans: ['Inter', 'sans-serif'],
  },
}
Semua komponen wajib dibuat responsif menggunakan MerakiUI patterns.
________________________________________
🟩 6. Database & Migrasi
Buat rancangan tabel:
Tabel utama:
•	users
•	roles
•	teachers
•	students
•	parents
•	parent_student
•	classes
•	subjects
•	materials
•	schedules
•	attendances
•	exams
•	grades
•	invoices
•	announcements
•	contact_messages
•	news
•	galleries
Buat seluruh migrasi dengan foreign key lengkap, cascade delete, timestamp wajib.
________________________________________
🟩 7. Routing
Gunakan:
•	Web routes untuk public + dashboard
•	Route group per role
•	Middleware: role:admin, role:teacher, dll
Contoh:
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::resource('teachers', TeacherController::class);
    });
________________________________________
🟩 8. Controller + Service Layer
Kamu harus membangunkan semua controller berikut:
Admin
•	UserController
•	TeacherController
•	StudentController
•	ParentController
•	ClassController
•	SubjectController
•	MaterialController
•	ScheduleController
•	AttendanceController
•	InvoiceController
Guru
•	TeacherDashboardController
•	AttendanceController
•	MaterialController
•	GradeController
•	ExamController
•	AnnouncementController
Siswa
•	StudentDashboardController
•	AttendanceController
•	GradeController
•	MaterialController
•	AnnouncementController
Orang tua
•	ParentDashboardController
•	StudentDetailController
•	InvoiceController
•	AttendanceController
•	AnnouncementController
________________________________________
🟩 9. Desain UI (MerakiUI Style)
Minta AI menghasilkan semua tampilan menggunakan komponen MerakiUI:
•	https://merakiui.com/components
•	Pastikan:
o	Grid modern
o	Card UI
o	Clean white spacing
o	Button modern rounded-xl
o	Shadow-md halus
o	Mobile navigation collapse
o	Sidebar otomatis berubah ke drawer saat mobile
________________________________________
🟩 10. Output yang harus dihasilkan AI
Minta AI menghasilkan seluruh hal berikut secara lengkap:
1. Struktur folder Laravel lengkap
2. Semua migrasi database
3. Semua model + relasi antar tabel
4. Semua controller + method lengkap
5. Service & Repository pattern
6. Route lengkap
7. Seluruh Blade layout
8. Semua komponen MerakiUI (header, sidebar, table, card)
9. Seluruh halaman publik
10. Seluruh halaman dashboard setiap role
11. Contoh UI
12. Contoh aksi CRUD lengkap
13. Validasi form
14. Seeder awal data sekolah
15. Mekanisme upload file untuk galeri & materi
16. Mekanisme download materi siswa
17. Mekanisme input nilai guru
18. Ringkasan kehadiran admin
19. Invoice siswa & orang tua
20. Kontakt form yang menyimpan ke tabel contact_messages
________________________________________

