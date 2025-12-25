<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $subjectsWithAttendance = Attendance::where('student_id', $student->id)
            ->with(['schedule.subject'])
            ->get()
            ->groupBy(fn ($attendance) => $attendance->schedule->subject->id)
            ->map(function ($attendances) {

                $subject = $attendances->first()->schedule->subject;

                $stats = [
                    'hadir' => $attendances->where('status', 'present')->count(),
                    'izin' => $attendances->where('status', 'excused')->count(),
                    'terlambat' => $attendances->where('status', 'late')->count(),
                    'tidak_hadir' => $attendances->where('status', 'absent')->count(),
                    'total' => $attendances->count(),
                ];

                $stats['persentase_hadir'] = $stats['total'] > 0
                    ? round(($stats['hadir'] / $stats['total']) * 100, 1)
                    : 0;

                return [
                    'subject' => $subject,
                    'attendances' => $attendances,
                    'stats' => $stats
                ];
            })
            ->values();

        return view('siswa.attendances.index', compact('subjectsWithAttendance'));
    }

    public function show($subjectId)
    {
        $student = Auth::user()->student;
        $subject = Subject::findOrFail($subjectId);

        /**
         * Ambil SEMUA data (untuk statistik)
         */
        $allAttendances = Attendance::where('student_id', $student->id)
            ->whereHas('schedule', fn ($q) => $q->where('subject_id', $subjectId))
            ->get();

        /**
         * Ambil data untuk tabel (pagination)
         */
        $attendances = Attendance::where('student_id', $student->id)
            ->whereHas('schedule', fn ($q) => $q->where('subject_id', $subjectId))
            ->with(['schedule.teacher.user'])
            ->orderBy('date', 'desc')
            ->paginate(15);

        $stats = [
            'hadir' => $allAttendances->where('status', 'present')->count(),
            'izin' => $allAttendances->where('status', 'excused')->count(),
            'terlambat' => $allAttendances->where('status', 'late')->count(),
            'tidak_hadir' => $allAttendances->where('status', 'absent')->count(),
            'total' => $allAttendances->count(),
        ];

        $stats['persentase_hadir'] = $stats['total'] > 0
            ? round(($stats['hadir'] / $stats['total']) * 100, 1)
            : 0;

        return view('siswa.attendances.show', compact(
            'subject',
            'attendances',
            'stats'
        ));
    }
}
