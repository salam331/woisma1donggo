<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['layout' => 'publik']);
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\SchoolProfilePublicController;
use App\Http\Controllers\AnnouncementPublicController;
use App\Http\Controllers\GalleryPublicController;

Route::get('/about', [SchoolProfilePublicController::class, 'show'])->name('about');

Route::get('/gallery', [GalleryPublicController::class, 'index'])->name('gallery');
Route::get('/gallery/{id}', [GalleryPublicController::class, 'show'])->name('gallery.show');

Route::get('/announcements', [AnnouncementPublicController::class, 'index'])->name('announcements');

Route::get('/contact', function () {
    return view('contact', ['layout' => 'publik']);
})->name('contact');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);

    // Teacher Management
    Route::resource('teachers', TeacherController::class);

    // Student Management
    Route::resource('students', StudentController::class);

    // Parent Management
    Route::resource('parents', ParentController::class);

    // Class Management
    Route::resource('classes', SchoolClassController::class);
    Route::get('classes/{class}/students', [SchoolClassController::class, 'students'])->name('classes.students');


    // Subject Management
    Route::resource('subjects', SubjectController::class);

    // Material Management
    Route::resource('materials', MaterialController::class);
    Route::get('materials/{material}/download', [MaterialController::class, 'download'])->name('materials.download');

    // Schedule Management
    Route::resource('schedules', ScheduleController::class);

    // Attendance Management
    Route::get('attendances/summary', [AttendanceController::class, 'summary'])->name('attendances.summary');
    Route::get('attendances/class/{classId}', [AttendanceController::class, 'indexByClass'])->name('attendances.index-by-class');
    Route::get('attendances/class/{classId}/subject/{subjectId}', [AttendanceController::class, 'indexBySubject'])->name('attendances.index-by-subject');
    Route::resource('attendances', AttendanceController::class);

    // Invoice Management
    Route::resource('invoices', InvoiceController::class);

    // School Profile Management
    Route::resource('school-profiles', SchoolProfileController::class);

    // Announcement Management
    Route::resource('announcements', AnnouncementController::class);

    // Gallery Management
    Route::resource('galleries', GalleryController::class);

    // Contact Message Management
    Route::resource('contact-messages', ContactMessageController::class);
});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:orang_tua'])->prefix('orang_tua')->name('orang_tua.')->group(function () {
    Route::get('/dashboard', function () {
        return view('orang_tua.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
