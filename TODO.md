# Perbaikan Error: Unknown column 'student.name' in 'order clause'

## Information Gathered
- Error terjadi di ExamController.php method show() line 122
- SQL Query yang gagal: `select * from grades where exam_id = 4 order by student.name asc`
- Masalah: `orderBy('student.name')` tidak valid untuk relasi Eloquent
- Grades table memiliki foreign key ke students table
- Student model memiliki field 'name'

## Plan
1. Fix orderBy clause di ExamController.php method show()
2. Gunakan join() untuk menggabungkan dengan students table
3. Update query ordering untuk menggunakan nama siswa dengan benar
4. Test fix dengan menjalankan aplikasi

## Dependent Files to be edited
- app/Http/Controllers/Teacher/ExamController.php (line 122)

## Followup steps
1. Test perbaikan dengan mengakses halaman ujian guru
2. Pastikan data grades ditampilkan dengan urutan nama siswa yang benar
3. Verifikasi tidak ada error lain yang muncul


## Progress
- [x] Analisis masalah dan identifikasi root cause
- [x] Implementasi perbaikan pada ExamController.php
- [x] Membuat view show.blade.php yang hilang
- [x] Membuat view edit.blade.php yang hilang
- [x] Membuat view create.blade.php yang hilang
- [x] Testing perbaikan

## Hasil Perbaikan Lengkap
✅ Error SQL query sudah diperbaiki
✅ Halaman detail ujian (`/guru/exams/{id}`) sudah dapat diakses
✅ Halaman edit ujian (`/guru/exams/{id}/edit`) sudah dapat diakses
✅ Halaman create ujian (`/guru/exams/create`) sudah dapat diakses
✅ Data grades ditampilkan dengan urutan nama siswa yang benar
✅ Tampilan responsif dengan support dark mode
✅ Statistik dan analisis data nilai
✅ Validasi form yang lengkap
✅ JavaScript untuk kalkulasi durasi ujian

