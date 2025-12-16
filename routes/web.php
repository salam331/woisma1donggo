<?php

use Illuminate\Support\Facades\Route;

// Public Controllers
use App\Http\Controllers\SchoolProfilePublicController;
use App\Http\Controllers\AnnouncementPublicController;
use App\Http\Controllers\GalleryPublicController;
use App\Http\Controllers\ContactFormController;

// Profile Controller
use App\Http\Controllers\ProfileController;

// Teacher Controllers
use App\Http\Controllers\Teacher\ClassController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\ScheduleController as TeacherScheduleController;
use App\Http\Controllers\Teacher\MaterialController as TeacherMaterialController;
use App\Http\Controllers\Teacher\SubjectController as TeacherSubjectController;
use App\Http\Controllers\Teacher\AnnouncementController as TeacherAnnouncementController;
use App\Http\Controllers\Teacher\GradeController as TeacherGradeController;
use App\Http\Controllers\Teacher\ExamController as TeacherExamController;

// Admin Controllers
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
use App\Http\Controllers\Admin\ExamController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('dashboard', ['layout' => 'publik']);
})->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard.auth');

// Profil Sekolah
Route::get('/about', [SchoolProfilePublicController::class, 'show'])->name('about');

// Galeri Publik
Route::get('/gallery', [GalleryPublicController::class, 'index'])->name('gallery');
Route::get('/gallery/{id}', [GalleryPublicController::class, 'show'])
    ->name('gallery.show'); // PERBAIKAN: route tidak bentrok dengan admin karena admin pakai prefix "admin"

// Informasi Akademik
Route::get('/informasi-akademik', function () {
    return view('informasi-akademik');
})->name('informasi-akademik');

// Pengumuman Publik
Route::get('/announcements', [AnnouncementPublicController::class, 'index'])->name('announcements');

// Contact Page
Route::get('/contact', fn() => view('contact', ['layout' => 'publik']))->name('contact');
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');


/*
|--------------------------------------------------------------------------
| PROFILE (Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('users', UserController::class);
    Route::post('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::post('users/{user}/reactivate', [UserController::class, 'reactivate'])->name('users.reactivate');

    // Teachers
    Route::resource('teachers', TeacherController::class);

    // Students
    Route::resource('students', StudentController::class);

    // Parents
    Route::resource('parents', ParentController::class);

    // Classes
    Route::resource('classes', SchoolClassController::class);
    Route::get('classes/{class}/students', [SchoolClassController::class, 'students'])->name('classes.students');

    // Subjects
    Route::resource('subjects', SubjectController::class);

    // Materials
    Route::resource('materials', MaterialController::class);
    Route::get('materials/{material}/download', [MaterialController::class, 'download'])->name('materials.download');

    // Schedules
    Route::resource('schedules', ScheduleController::class);

    // Attendance
    Route::get('attendances/summary', [AttendanceController::class, 'summary'])->name('attendances.summary');
    Route::get('attendances/class/{classId}', [AttendanceController::class, 'indexByClass'])->name('attendances.index-by-class');
    Route::get('attendances/class/{classId}/subject/{subjectId}', [AttendanceController::class, 'indexBySubject'])->name('attendances.index-by-subject');
    Route::get('attendances/student/{studentId}/subject/{subjectId}', [AttendanceController::class, 'studentAttendanceHistory'])->name('attendances.student-history');
    Route::resource('attendances', AttendanceController::class);

    // Invoices
    Route::resource('invoices', InvoiceController::class);

    // School Profiles
    Route::resource('school-profiles', SchoolProfileController::class);

    // Announcements
    Route::resource('announcements', AnnouncementController::class);

    // Galleries
    Route::resource('galleries', GalleryController::class);

    // Contact Messages
    Route::resource('contact-messages', ContactMessageController::class);

    // Grades (nilai)
    Route::resource('grades', \App\Http\Controllers\Admin\GradeController::class);
    Route::get('grades/get-subjects/{classId}', [\App\Http\Controllers\Admin\GradeController::class, 'getSubjectsByClass'])->name('grades.get-subjects');
    Route::get('grades/get-exams/{classId}/{subjectId}', [\App\Http\Controllers\Admin\GradeController::class, 'getExamsByClassAndSubject'])->name('grades.get-exams');
    Route::get('grades/get-students/{classId}', [\App\Http\Controllers\Admin\GradeController::class, 'getStudentsByClass'])->name('grades.get-students');

    // Hierarchical grades routes
    Route::get('grades/class/{classId}', [\App\Http\Controllers\Admin\GradeController::class, 'showClass'])->name('grades.class');
    Route::get('grades/class/{classId}/subject/{subjectId}', [\App\Http\Controllers\Admin\GradeController::class, 'showSubject'])->name('grades.subject');
    Route::get('grades/class/{classId}/subject/{subjectId}/exam/{examId}', [\App\Http\Controllers\Admin\GradeController::class, 'showExam'])->name('grades.exam');
    Route::get('grades/class/{classId}/subject/{subjectId}/exam/{examId}/edit', [\App\Http\Controllers\Admin\GradeController::class, 'editExam'])->name('grades.edit-exam');
    Route::put('grades/class/{classId}/subject/{subjectId}/exam/{examId}/update', [\App\Http\Controllers\Admin\GradeController::class, 'updateExam'])->name('grades.update-exam');
    Route::get('grades/class/{classId}/subject/{subjectId}/exam/{examId}/student/{studentId}', [\App\Http\Controllers\Admin\GradeController::class, 'showStudent'])->name('grades.student');

    // Exams (ujian)
    Route::resource('exams', ExamController::class);
    Route::get('exams/get-teachers/{classId}', [ExamController::class, 'getTeachersByClass'])->name('exams.get-teachers');
    Route::get('exams/get-subjects/{teacherId}', [ExamController::class, 'getSubjectsByTeacher'])->name('exams.get-subjects');

});


/*
|--------------------------------------------------------------------------
| GURU ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

    Route::get('/dashboard', fn() => view('guru.dashboard'))->name('dashboard');



    // Classes
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{class}', [ClassController::class, 'show'])->name('classes.show');
    Route::get('/classes/{class}/students', [ClassController::class, 'students'])->name('classes.students');
    Route::get('/classes/{class}/students/json', [ClassController::class, 'studentsJson'])->name('classes.students.json');


    // Attendances
    Route::get('/attendances', [TeacherAttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/create', [TeacherAttendanceController::class, 'create'])->name('attendances.create');
    Route::post('/attendances', [TeacherAttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/attendances/summary', [TeacherAttendanceController::class, 'summary'])->name('attendances.summary');
    Route::get('/attendances/{attendance}', [TeacherAttendanceController::class, 'show'])->name('attendances.show');
    Route::get('/attendances/{attendance}/edit', [TeacherAttendanceController::class, 'edit'])->name('attendances.edit');
    Route::put('/attendances/{attendance}', [TeacherAttendanceController::class, 'update'])->name('attendances.update');
    Route::delete('/attendances/{attendance}', [TeacherAttendanceController::class, 'destroy'])->name('attendances.destroy');
    Route::get('/attendances/class/{classId}', [TeacherAttendanceController::class, 'indexByClass'])->name('attendances.index-by-class');
    Route::get('/attendances/class/{classId}/subject/{subjectId}', [TeacherAttendanceController::class, 'indexBySubject'])->name('attendances.index-by-subject');
    Route::get('/attendances/student/{studentId}/subject/{subjectId}', [TeacherAttendanceController::class, 'studentHistory'])->name('attendances.student-history');

    // Schedules
    Route::get('/schedules', [TeacherScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/{schedule}', [TeacherScheduleController::class, 'show'])->name('schedules.show');

    // Materials
    Route::resource('materials', TeacherMaterialController::class);
    Route::get('materials/{material}/download', [TeacherMaterialController::class, 'download'])->name('materials.download');

    // Subjects
    Route::get('/subjects', [TeacherSubjectController::class, 'index'])->name('subjects.index');
    Route::get('/subjects/{subject}', [TeacherSubjectController::class, 'show'])->name('subjects.show');


    // Announcements - Only view routes (creation/editing is handled by admin)
    Route::get('/announcements', [TeacherAnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/{announcement}', [TeacherAnnouncementController::class, 'show'])->name('announcements.show');

    // Grades (nilai)
    Route::get('/grades', [TeacherGradeController::class, 'index'])->name('grades.index');
    Route::get('/grades/class/{classId}', [TeacherGradeController::class, 'showClass'])->name('grades.class');
    Route::get('/grades/class/{classId}/subject/{subjectId}', [TeacherGradeController::class, 'showSubject'])->name('grades.subject');
    Route::get('/grades/class/{classId}/subject/{subjectId}/exam/{examId}', [TeacherGradeController::class, 'showExam'])->name('grades.exam');
    Route::get('/grades/class/{classId}/subject/{subjectId}/exam/{examId}/edit', [TeacherGradeController::class, 'editExam'])->name('grades.edit-exam');
    Route::put('/grades/class/{classId}/subject/{subjectId}/exam/{examId}/update', [TeacherGradeController::class, 'updateExam'])->name('grades.update-exam');
    Route::get('/grades/class/{classId}/subject/{subjectId}/exam/{examId}/student/{studentId}', [TeacherGradeController::class, 'showStudent'])->name('grades.student');

    // AJAX routes for grades
    Route::get('grades/get-subjects/{classId}', [TeacherGradeController::class, 'getSubjectsByClass'])->name('grades.get-subjects');
    Route::get('grades/get-exams/{classId}/{subjectId}', [TeacherGradeController::class, 'getExamsByClassAndSubject'])->name('grades.get-exams');
    Route::get('grades/get-students/{classId}', [TeacherGradeController::class, 'getStudentsByClass'])->name('grades.get-students');

    // Exams (ujian)
    Route::resource('exams', TeacherExamController::class);
    Route::get('exams/get-teachers/{classId}', [TeacherExamController::class, 'getTeachersByClass'])->name('exams.get-teachers');
    Route::get('exams/get-subjects/{teacherId}', [TeacherExamController::class, 'getSubjectsByTeacher'])->name('exams.get-subjects');
});


/*
|--------------------------------------------------------------------------
| SISWA ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

    Route::get('/dashboard', fn() => view('siswa.dashboard'))->name('dashboard');
});


/*
|--------------------------------------------------------------------------
| ORANG TUA ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:orang_tua'])
    ->prefix('orang_tua')
    ->name('orang_tua.')
    ->group(function () {

    Route::get('/dashboard', fn() => view('orang_tua.dashboard'))->name('dashboard');
});


require __DIR__ . '/auth.php';
