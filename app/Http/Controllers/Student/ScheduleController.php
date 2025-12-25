<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ScheduleController extends Controller
{
    /**
     * Menampilkan jadwal pelajaran siswa
     */
    public function index()
    {
        $student = Auth::user()->student;

        if (!$student || !$student->school_class_id) {
            return redirect()
                ->route('siswa.dashboard')
                ->with('error', 'Data kelas tidak ditemukan.');
        }

        $schedules = Schedule::where('class_id', $student->school_class_id)
            ->with([
                'teacher.user',
                'subject'
            ])
            ->orderByRaw("
                FIELD(day,
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday'
                )
            ")
            ->orderBy('start_time')
            ->get();

        return view('siswa.schedules.index', compact('schedules'));
    }

    /**
     * Download jadwal pelajaran dalam bentuk PDF
     */
    public function downloadSchedule()
    {
        $student = Auth::user()->student;

        if (!$student || !$student->school_class_id) {
            return redirect()
                ->route('siswa.dashboard')
                ->with('error', 'Data kelas tidak ditemukan.');
        }

        $schedules = Schedule::where('class_id', $student->school_class_id)
            ->with([
                'teacher.user',
                'subject'
            ])
            ->orderByRaw("
                FIELD(day,
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday'
                )
            ")
            ->orderBy('start_time')
            ->get();

        $pdf = Pdf::loadView(
            'siswa.schedules.download',
            [
                'schedules' => $schedules,
                'student'   => $student
            ]
        )->setPaper('A4', 'landscape');

        return $pdf->download(
            'Jadwal_Pelajaran_' . str_replace(' ', '_', $student->name) . '.pdf'
        );
    }
}
