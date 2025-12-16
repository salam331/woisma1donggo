<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules for the authenticated teacher.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $schedules = Schedule::where('teacher_id', $teacher->id)
            ->with(['class', 'subject'])
            ->orderByRaw("FIELD(day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')")
            ->orderBy('start_time')
            ->get();

        return view('guru.schedules.index', compact('schedules'));
    }

    /**
     * Display the specified schedule.
     */
    public function show(Schedule $schedule)
    {
        $teacher = Auth::user()->teacher;

        // Verify the schedule belongs to this teacher
        if ($schedule->teacher_id !== $teacher->id) {
            abort(403);
        }

        $schedule->load(['class.students', 'subject']);

        return view('guru.schedules.show', compact('schedule'));
    }
}
