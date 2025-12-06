<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource grouped by class.
     */
    public function index(Request $request)
    {
        $classes = \App\Models\SchoolClass::all();

        $classSummaries = $classes->map(function ($class) {
            $totalAttendances = Attendance::whereHas('schedule', function ($q) use ($class) {
                $q->where('class_id', $class->id);
            })->count();

            $presentCount = Attendance::whereHas('schedule', function ($q) use ($class) {
                $q->where('class_id', $class->id);
            })->where('status', 'present')->count();

            $absentCount = Attendance::whereHas('schedule', function ($q) use ($class) {
                $q->where('class_id', $class->id);
            })->where('status', 'absent')->count();

            $lateCount = Attendance::whereHas('schedule', function ($q) use ($class) {
                $q->where('class_id', $class->id);
            })->where('status', 'late')->count();

            $excusedCount = Attendance::whereHas('schedule', function ($q) use ($class) {
                $q->where('class_id', $class->id);
            })->where('status', 'excused')->count();

            return [
                'class' => $class,
                'total_attendances' => $totalAttendances,
                'present_count' => $presentCount,
                'absent_count' => $absentCount,
                'late_count' => $lateCount,
                'excused_count' => $excusedCount,
                'present_percentage' => $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100, 2) : 0,
            ];
        });

        return view('admin.attendances.index', compact('classSummaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = \App\Models\SchoolClass::all();
        $schedules = Schedule::with(['class', 'subject'])->get();
        return view('admin.attendances.create', compact('classes', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.schedule_id' => 'required|exists:schedules,id',
            'attendances.*.date' => 'required|date',
            'attendances.*.status' => 'required|in:present,absent,late,excused',
            'attendances.*.notes' => 'nullable|string',
        ]);

        foreach ($request->attendances as $attendanceData) {
            Attendance::create($attendanceData);
        }

        return redirect()->route('admin.attendances.index')->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        $attendance->load(['student', 'schedule.subject', 'schedule.class']);
        $subject = $attendance->schedule->subject;
        return view('admin.attendances.show', compact('attendance', 'subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        $students = Student::all();
        $schedules = Schedule::with(['class', 'subject'])->get();
        return view('admin.attendances.edit', compact('attendance', 'students', 'schedules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'schedule_id' => 'required|exists:schedules,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
            'notes' => 'nullable|string',
        ]);

        $attendance->update($request->all());

        return redirect()->route('admin.attendances.index')->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('admin.attendances.index')->with('success', 'Attendance deleted successfully.');
    }

    /**
     * Show attendance summary.
     */
    public function summary(Request $request)
    {
        $query = Attendance::with(['student.class', 'schedule.subject']);

        if ($request->has('month') && $request->month) {
            $query->whereMonth('date', $request->month);
        }

        if ($request->has('year') && $request->year) {
            $query->whereYear('date', $request->year);
        }

        $attendances = $query->get();

        $summary = $attendances->groupBy('student_id')->map(function ($studentAttendances) {
            $total = $studentAttendances->count();
            $present = $studentAttendances->where('status', 'present')->count();
            $absent = $studentAttendances->where('status', 'absent')->count();
            $late = $studentAttendances->where('status', 'late')->count();
            $excused = $studentAttendances->where('status', 'excused')->count();

            return [
                'student' => $studentAttendances->first()->student,
                'total' => $total,
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
                'excused' => $excused,
                'present_percentage' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
            ];
        });

        return view('admin.attendances.summary', compact('summary'));
    }

    /**
     * Display attendances grouped by subject within a class.
     */
    public function indexByClass($classId)
    {
        $class = \App\Models\SchoolClass::with(['schedules.subject'])->findOrFail($classId);

        $subjects = $class->schedules->groupBy('subject_id')->map(function ($schedules, $subjectId) use ($classId) {
            $subject = $schedules->first()->subject;

            $baseQuery = Attendance::whereHas('schedule', function ($q) use ($classId, $subjectId) {
                $q->where('class_id', $classId)->where('subject_id', $subjectId);
            });

            $totalAttendances = $baseQuery->count();
            $presentCount = (clone $baseQuery)->where('status', 'present')->count();
            $absentCount = (clone $baseQuery)->where('status', 'absent')->count();
            $lateCount = (clone $baseQuery)->where('status', 'late')->count();
            $excusedCount = (clone $baseQuery)->where('status', 'excused')->count();

            return [
                'subject' => $subject,
                'total_attendances' => $totalAttendances,
                'present_count' => $presentCount,
                'absent_count' => $absentCount,
                'late_count' => $lateCount,
                'excused_count' => $excusedCount,
                'present_percentage' => $totalAttendances > 0
                    ? round(($presentCount / $totalAttendances) * 100, 2)
                    : 0,
            ];
        });

        return view('admin.attendances.index-by-class', compact('class', 'subjects', 'classId'));
    }

    /**
     * Display attendances per student within a class and subject.
     */
    public function indexBySubject($classId, $subjectId)
    {
        $class = \App\Models\SchoolClass::with('students')->findOrFail($classId);
        $subject = \App\Models\Subject::findOrFail($subjectId);

        $students = $class->students()->paginate(10);

        $attendances = Attendance::with(['student', 'schedule'])
            ->whereHas('schedule', function ($query) use ($classId, $subjectId) {
                $query->where('class_id', $classId)
                      ->where('subject_id', $subjectId);
            })
            ->paginate(10);

        return view('admin.attendances.index-by-subject', compact('class', 'subject', 'students', 'attendances'));
    }

    /**
     * Show attendance history per student and subject.
     */
    public function studentAttendanceHistory($studentId, $subjectId)
    {
        $student = \App\Models\Student::findOrFail($studentId);
        $subject = \App\Models\Subject::findOrFail($subjectId);

        $attendances = Attendance::with('schedule')
            ->where('student_id', $studentId)
            ->whereHas('schedule', function ($query) use ($subjectId) {
                $query->where('subject_id', $subjectId);
            })
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('admin.attendances.student-history', compact('student', 'subject', 'attendances'));
    }
}
