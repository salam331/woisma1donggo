<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the subjects taught by the authenticated teacher.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $subjects = Subject::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with(['schedules' => function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id)->with('class');
        }])->get();

        return view('guru.subjects.index', compact('subjects'));
    }

    /**
     * Display the specified subject.
     */
    public function show(Subject $subject)
    {
        $teacher = Auth::user()->teacher;

        // Verify the teacher teaches this subject
        $hasAccess = \App\Models\Schedule::where('teacher_id', $teacher->id)
            ->where('subject_id', $subject->id)
            ->exists();

        if (!$hasAccess) {
            abort(403);
        }

        $subject->load(['schedules' => function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id)->with('class');
        }]);

        return view('guru.subjects.show', compact('subject'));
    }
}
