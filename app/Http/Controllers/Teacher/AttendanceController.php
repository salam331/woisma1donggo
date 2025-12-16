<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the attendance records for the authenticated teacher.
     */
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Get all classes taught by this teacher (based on schedules)
        $teacherClasses = \App\Models\SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->orderBy('name')->get();

        // Get selected class ID from request
        $selectedClassId = $request->get('class_id');
        $selectedClass = null;

        // If no class selected, use the first class
        if (!$selectedClassId && $teacherClasses->count() > 0) {
            $selectedClassId = $teacherClasses->first()->id;
        }

        // Get selected class details
        if ($selectedClassId) {
            $selectedClass = \App\Models\SchoolClass::with(['schedules.subject'])->find($selectedClassId);

            // Verify teacher teaches this class
            if (!$selectedClass || !$selectedClass->schedules()->where('teacher_id', $teacher->id)->exists()) {
                return redirect()->route('guru.attendances.index')->with('error', 'Anda tidak memiliki akses ke kelas ini.');
            }
        }

        // Get today's date
        $today = Carbon::today();

        // Get attendance records for today
        $todayAttendances = Attendance::whereHas('schedule', function ($query) use ($teacher, $selectedClassId) {
            $query->where('teacher_id', $teacher->id);
            if ($selectedClassId) {
                $query->where('class_id', $selectedClassId);
            }
        })
        ->whereDate('date', $today)
        ->with(['schedule.class', 'schedule.subject', 'student'])
        ->orderBy('created_at', 'desc')
        ->get();

        // Get attendance history (7 days)
        $sevenDaysAgo = Carbon::today()->subDays(7);
        $attendanceHistory = Attendance::whereHas('schedule', function ($query) use ($teacher, $selectedClassId) {
            $query->where('teacher_id', $teacher->id);
            if ($selectedClassId) {
                $query->where('class_id', $selectedClassId);
            }
        })
        ->whereDate('date', '>=', $sevenDaysAgo)
        ->whereDate('date', '<', $today)
        ->with(['schedule.class', 'schedule.subject', 'student'])
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        // Get schedules for today
        $todaySchedules = Schedule::where('teacher_id', $teacher->id);
        if ($selectedClassId) {
            $todaySchedules = $todaySchedules->where('class_id', $selectedClassId);
        }
        $todaySchedules = $todaySchedules->with(['class', 'subject'])
            ->orderBy('start_time')
            ->get();

        // Get subjects for the selected class taught by this teacher
        $subjects = collect();
        if ($selectedClass) {
            $subjects = $selectedClass->schedules()
                ->where('teacher_id', $teacher->id)
                ->with('subject')
                ->get()
                ->pluck('subject')
                ->unique('id')
                ->values();
        }

        // Debug: Log data yang dikirim
        \Log::info('Attendance Index Data', [
            'teacherClasses_count' => $teacherClasses->count(),
            'selectedClassId' => $selectedClassId,
            'selectedClass' => $selectedClass ? $selectedClass->name : 'null',
            'todayAttendances_count' => $todayAttendances->count(),
            'subjects_count' => $subjects->count(),
        ]);

        return view('guru.attendances.index', compact(
            'teacherClasses',
            'selectedClass',
            'selectedClassId',
            'todayAttendances',
            'attendanceHistory',
            'todaySchedules',
            'today',
            'sevenDaysAgo',
            'subjects'
        ));
    }


    /**
     * Show the form for creating a new attendance record.
     */
    public function create(Request $request)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Get all classes taught by this teacher
        $teacherClasses = \App\Models\SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->orderBy('name')->get();

        // Get all schedules for this teacher
        $schedules = Schedule::where('teacher_id', $teacher->id)
            ->with(['class', 'subject'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        // If schedule_id and date are provided, load specific schedule
        $schedule = null;
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        $scheduleId = $request->get('schedule_id');
        if ($scheduleId) {
            $schedule = Schedule::where('id', $scheduleId)
                ->where('teacher_id', $teacher->id)
                ->with(['class.students', 'subject'])
                ->firstOrFail();

            // Get existing attendance records for this schedule and date
            $existingAttendances = Attendance::where('schedule_id', $scheduleId)
                ->whereDate('date', $date)
                ->pluck('student_id')
                ->toArray();
        } else {
            $existingAttendances = [];
        }

        return view('guru.attendances.create', compact(
            'teacherClasses', 
            'schedules', 
            'schedule', 
            'date', 
            'existingAttendances'
        ));
    }

    /**
     * Store a newly created attendance record in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status' => 'required|in:present,absent,late,excused',
            'attendances.*.notes' => 'nullable|string|max:255',
        ]);

        $teacher = Auth::user()->teacher;

        // Verify the schedule belongs to this teacher
        $schedule = Schedule::where('id', $request->schedule_id)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $attendances = [];
        foreach ($request->attendances as $attendanceData) {
            $attendances[] = [
                'schedule_id' => $request->schedule_id,
                'student_id' => $attendanceData['student_id'],
                'date' => $request->date,
                'status' => $attendanceData['status'],
                'notes' => $attendanceData['notes'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Attendance::insert($attendances);

        return redirect()->route('guru.attendances.index')
            ->with('success', 'Data absensi berhasil disimpan.');
    }

    /**
     * Display the specified attendance record.
     */
    public function show(Attendance $attendance)
    {
        $teacher = Auth::user()->teacher;

        // Verify the attendance belongs to this teacher's schedule
        if ($attendance->schedule->teacher_id !== $teacher->id) {
            abort(403);
        }

        $attendance->load(['schedule.class', 'schedule.subject', 'student']);

        return view('guru.attendances.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified attendance record.
     */
    public function edit(Attendance $attendance)
    {
        $teacher = Auth::user()->teacher;

        // Verify the attendance belongs to this teacher's schedule
        if ($attendance->schedule->teacher_id !== $teacher->id) {
            abort(403);
        }

        $attendance->load(['schedule.class', 'schedule.subject', 'student']);

        return view('guru.attendances.edit', compact('attendance'));
    }

    /**
     * Update the specified attendance record in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $teacher = Auth::user()->teacher;

        // Verify the attendance belongs to this teacher's schedule
        if ($attendance->schedule->teacher_id !== $teacher->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:present,absent,late,excused',
            'notes' => 'nullable|string|max:255',
        ]);

        $attendance->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('guru.attendances.index')
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    /**
     * Remove the specified attendance record from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $teacher = Auth::user()->teacher;

        // Verify the attendance belongs to this teacher's schedule
        if ($attendance->schedule->teacher_id !== $teacher->id) {
            abort(403);
        }

        $attendance->delete();

        return redirect()->route('guru.attendances.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }

    /**
     * Show attendance records by class.
     */
    public function indexByClass($classId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $class = \App\Models\SchoolClass::findOrFail($classId);

        // Verify the teacher teaches this class
        $hasAccess = Schedule::where('class_id', $classId)
            ->where('teacher_id', $teacher->id)
            ->exists();

        if (!$hasAccess) {
            abort(403);
        }

        $attendances = Attendance::whereHas('schedule', function ($query) use ($classId, $teacher) {
            $query->where('class_id', $classId)
                  ->where('teacher_id', $teacher->id);
        })
        ->with(['schedule.subject', 'student'])
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('guru.attendances.index-by-class', compact('class', 'attendances'));
    }

    /**
     * Show attendance records by subject.
     */
    public function indexBySubject($classId, $subjectId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $class = \App\Models\SchoolClass::findOrFail($classId);
        $subject = \App\Models\Subject::findOrFail($subjectId);

        // Verify the teacher teaches this subject in this class
        $hasAccess = Schedule::where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->where('teacher_id', $teacher->id)
            ->exists();

        if (!$hasAccess) {
            abort(403);
        }

        $attendances = Attendance::whereHas('schedule', function ($query) use ($classId, $subjectId, $teacher) {
            $query->where('class_id', $classId)
                  ->where('subject_id', $subjectId)
                  ->where('teacher_id', $teacher->id);
        })
        ->with(['student'])
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        // Get students in this class
        $students = Student::where('school_class_id', $classId)
            ->orderBy('name')
            ->paginate(20);

        return view('guru.attendances.index-by-subject', compact('class', 'subject', 'attendances', 'students'));
    }

    /**
     * Show student attendance history.
     */
    public function studentHistory($studentId, $subjectId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $student = Student::with('class')->findOrFail($studentId);
        $subject = \App\Models\Subject::findOrFail($subjectId);

        // Verify the teacher teaches this subject to this student
        $hasAccess = Schedule::where('subject_id', $subjectId)
            ->where('teacher_id', $teacher->id)
            ->whereHas('class.students', function ($query) use ($studentId) {
                $query->where('students.id', $studentId);
            })
            ->exists();

        if (!$hasAccess) {
            abort(403);
        }

        $attendances = Attendance::where('student_id', $studentId)
            ->whereHas('schedule', function ($query) use ($subjectId, $teacher) {
                $query->where('subject_id', $subjectId)
                      ->where('teacher_id', $teacher->id);
            })
            ->with(['schedule'])
            ->orderBy('date', 'desc')
            ->paginate(20);


        return view('guru.attendances.student-history', compact('student', 'subject', 'attendances'));
    }

    /**
     * Show attendance summary report.
     */
    public function summary()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Get all classes taught by this teacher
        $teacherClasses = \App\Models\SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with(['schedules' => function($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        }])->get();

        // Calculate summary statistics
        $totalClasses = $teacherClasses->count();
        $totalSchedules = $teacherClasses->sum(function($class) {
            return $class->schedules->count();
        });

        // Get overall attendance statistics
        $attendanceStats = Attendance::whereHas('schedule', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->selectRaw('
            status,
            COUNT(*) as count
        ')->groupBy('status')->pluck('count', 'status')->toArray();

        $presentCount = $attendanceStats['present'] ?? 0;
        $absentCount = $attendanceStats['absent'] ?? 0;
        $lateCount = $attendanceStats['late'] ?? 0;
        $excusedCount = $attendanceStats['excused'] ?? 0;
        $totalAttendance = $presentCount + $absentCount + $lateCount + $excusedCount;

        $attendancePercentage = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 1) : 0;

        // Get monthly statistics
        $monthlyStats = Attendance::whereHas('schedule', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })
        ->whereMonth('date', date('n'))
        ->whereYear('date', date('Y'))
        ->selectRaw('
            status,
            COUNT(*) as count
        ')->groupBy('status')->pluck('count', 'status')->toArray();

        return view('guru.attendances.summary', compact(
            'teacherClasses',
            'totalClasses',
            'totalSchedules',
            'presentCount',
            'absentCount',
            'lateCount',
            'excusedCount',
            'totalAttendance',
            'attendancePercentage',
            'monthlyStats'
        ));
    }
}
