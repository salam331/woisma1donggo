# Perbaikan Halaman Kelas untuk Role Guru - BERDASARKAN JADWAL MENGJAR

## Informasi yang Dikumpulkan:
Masalah awal: Halaman kelas guru hanya menampilkan kelas di mana guru tersebut adalah wali kelas, bukan kelas di mana guru tersebut mengajar berdasarkan jadwal.

## Perbaikan yang Telah Dilakukan:

### 1. ✅ Memperbarui ClassController (index method)
**SEBELUM**: Menampilkan kelas berdasarkan `teacher_id` (wali kelas saja)
```php
$classes = SchoolClass::where('teacher_id', $teacher->id)
```

**SESUDAH**: Menampilkan kelas berdasarkan jadwal mengajar
```php
$classes = SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
    $query->where('teacher_id', $teacher->id);
})
```

### 2. ✅ Memperbarui Verifikasi Akses (show & students methods)
**SEBELUM**: Hanya berdasarkan wali kelas
```php
if ($class->teacher_id !== $teacher->id) {
    abort(403);
}
```

**SESUDAH**: Berdasarkan jadwal mengajar
```php
$hasSchedules = $class->schedules()->where('teacher_id', $teacher->id)->exists();
if (!$hasSchedules) {
    abort(403);
}
```

### 3. ✅ Memperbarui View show.blade.php
**SEBELUM**: Menampilkan semua jadwal kelas
```php
@if($class->schedules->count() > 0)
```

**SESUDAH**: Hanya menampilkan jadwal yang diajar guru tersebut
```php
@if(isset($class->teacher_schedules) && $class->teacher_schedules->count() > 0)
```

### 4. ✅ Menambahkan Data teacher_schedules di Controller
Menambahkan properti `$class->teacher_schedules` yang berisi hanya jadwal yang diajar oleh guru yang sedang login.

## Hasil Perbaikan:

### ✅ Masalah yang Diselesaikan:
- **Admin menambahkan jadwal pelajaran guru1 di kelas berbeda** → Guru sekarang melihat semua kelas di mana dia mengajar
- **Tidak terbatas hanya kelas sebagai wali kelas** → Guru bisa melihat kelas di mana dia mengajar mata pelajaran
- **Statistik yang lebih akurat** → Hanya menghitung data yang relevan dengan mengajar guru tersebut

### ✅ Fitur yang Berfungsi:
- ✅ Menampilkan kelas berdasarkan jadwal mengajar (bukan hanya wali kelas)
- ✅ Guru bisa melihat kelas-kelas di mana dia mengajar berbagai mata pelajaran
- ✅ Akses aman hanya untuk kelas yang diajar
- ✅ Statistik yang akurat untuk setiap kelas
- ✅ View yang hanya menampilkan data yang relevan

## Studi Kasus:
**Sebelum perbaikan:**
- Guru1 adalah wali kelas X
- Admin menambahkan jadwal Guru1 mengajar di kelas Y
- **Hasil**: Guru1 hanya melihat kelas X (sebagai wali kelas)

**Setelah perbaikan:**
- Guru1 adalah wali kelas X
- Admin menambahkan jadwal Guru1 mengajar di kelas Y
- **Hasil**: Guru1 melihat kelas X (wali kelas) + kelas Y (mengajar) = semua kelas yang dia ajar

## Status: SELESAI ✅
Halaman kelas untuk role guru telah diperbaiki untuk menampilkan semua kelas di mana guru tersebut mengajar berdasarkan jadwal, bukan hanya kelas di mana dia sebagai wali kelas.

---

# Perbaikan Halaman Absensi untuk Role Guru - FILTER BERDASARKAN KELAS

## Informasi yang Dikumpulkan:
Masalah awal: Halaman absensi guru menampilkan semua absensi dari semua kelas yang guru ajar tanpa filtering berdasarkan kelas tertentu. Tidak ada cara mudah untuk melihat data absensi per kelas.

## Perbaikan yang Telah Dilakukan:

### 1. ✅ Update AttendanceController::index() method
**SEBELUM**: Method hanya menerima request generik dan menampilkan semua absensi
```php
public function index()
{
    $teacher = Auth::user()->teacher;
    $schedules = Schedule::where('teacher_id', $teacher->id)...
    $attendances = Attendance::whereHas('schedule', function ($query) use ($teacher) {
        $query->where('teacher_id', $teacher->id);
    })...
}
```

**SESUDAH**: Method sekarang menerima parameter `class_id` dan menampilkan data berdasarkan kelas yang dipilih
```php
public function index(Request $request)
{
    $teacher = Auth::user()->teacher;
    
    // Get all classes taught by this teacher
    $teacherClasses = SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
        $query->where('teacher_id', $teacher->id);
    })->orderBy('name')->get();

    // Get selected class ID from request
    $selectedClassId = $request->get('class_id');
    
    // If no class selected, use the first class
    if (!$selectedClassId && $teacherClasses->count() > 0) {
        $selectedClassId = $teacherClasses->first()->id;
    }

    // Filter attendance records berdasarkan class_id
    $todayAttendances = Attendance::whereHas('schedule', function ($query) use ($teacher, $selectedClassId) {
        $query->where('teacher_id', $teacher->id);
        if ($selectedClassId) {
            $query->where('class_id', $selectedClassId);
        }
    })...

    // Get attendance history (7 hari terakhir)
    $attendanceHistory = Attendance::whereHas('schedule', function ($query) use ($teacher, $selectedClassId) {
        $query->where('teacher_id', $teacher->id);
        if ($selectedClassId) {
            $query->where('class_id', $selectedClassId);
        }
    })...
}
```

### 2. ✅ Update View index.blade.php
**PERUBAHAN UTAMA:**
- Menambahkan **dropdown filter kelas** di bagian atas halaman
- Menambahkan **Tab Navigation** dengan 3 tab:
  - Tab "Absensi Hari Ini" - menampilkan absensi hari ini untuk kelas yang dipilih
  - Tab "Riwayat (7 Hari)" - menampilkan riwayat absensi 7 hari terakhir untuk kelas yang dipilih
  - Tab "Jadwal Hari Ini" - menampilkan jadwal mengajar hari ini untuk kelas yang dipilih

**Fitur Tab:**
- Dropdown filter kelas dengan automatic selection ke kelas pertama jika tidak dipilih
- Tab switching menggunakan JavaScript function `switchTab()`
- Active tab memiliki blue underline (#2563eb)
- Setiap tab menampilkan data yang relevan berdasarkan class_id yang dipilih

### 3. ✅ Data yang Dikirim ke View
Controller sekarang mengirimkan data berikut ke view:
- `$teacherClasses` - semua kelas yang guru ajar
- `$selectedClass` - detail kelas yang dipilih
- `$selectedClassId` - ID kelas yang dipilih
- `$todayAttendances` - absensi hari ini untuk kelas terpilih
- `$attendanceHistory` - riwayat absensi (7 hari) untuk kelas terpilih (dengan pagination)
- `$todaySchedules` - jadwal mengajar hari ini untuk kelas terpilih
- `$today` - tanggal hari ini
- `$sevenDaysAgo` - tanggal 7 hari yang lalu

## Hasil Perbaikan:

### ✅ Masalah yang Diselesaikan:
- **Halaman absensi tidak terbatas ke satu kelas** → Guru sekarang bisa filter absensi berdasarkan kelas tertentu
- **Sulit melihat data absensi per kelas** → Dropdown filter memudahkan pemilihan kelas
- **Data tercampur dari berbagai kelas** → Tab yang terpisah membuat data lebih terorganisir

### ✅ Fitur yang Berfungsi:
- ✅ Dropdown filter untuk memilih kelas
- ✅ Automatic selection ke kelas pertama jika tidak ada yang dipilih
- ✅ Tab "Absensi Hari Ini" menampilkan absensi untuk kelas terpilih
- ✅ Tab "Riwayat (7 Hari)" menampilkan history dengan pagination
- ✅ Tab "Jadwal Hari Ini" menampilkan jadwal untuk kelas terpilih
- ✅ Akses aman - verifikasi guru mengajar kelas yang dipilih
- ✅ UI yang responsif dan user-friendly

## Studi Kasus:

**Skenario:**
- Guru1 mengajar di Kelas X (Matematika), Kelas X (IPA), dan Kelas XI (Matematika)
- Guru ingin melihat absensi Kelas X saja

**Sebelum perbaikan:**
- Guru hanya bisa melihat semua absensi dari ketiga kelas tercampur di satu halaman
- Tidak ada cara untuk filter per kelas

**Setelah perbaikan:**
- Guru membuka halaman Absensi
- Memilih "Kelas X" dari dropdown filter
- Klik tombol "Filter"
- Halaman menampilkan:
  - Tab "Absensi Hari Ini" → Absensi Kelas X hari ini saja
  - Tab "Riwayat (7 Hari)" → History absensi Kelas X
  - Tab "Jadwal Hari Ini" → Jadwal mengajar Kelas X hari ini

## Status: SELESAI ✅
Halaman absensi untuk role guru telah diperbaiki untuk menampilkan data berdasarkan kelas yang dipilih dengan 3 view tab (hari ini, riwayat, jadwal).

