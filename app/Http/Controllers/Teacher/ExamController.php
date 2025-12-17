<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of the exams created by the authenticated teacher.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }


        $exams = Exam::where('teacher_id', $teacher->id)
            ->with(['schoolClass', 'subject'])
            ->orderBy('exam_date', 'desc')
            ->paginate(12);

        return view('guru.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new exam.
     */
    public function create()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Get classes taught by this teacher
        $classes = \App\Models\SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        // Get subjects taught by this teacher
        $subjects = \App\Models\Subject::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        return view('guru.exams.create', compact('classes', 'subjects'));
    }


    /**
     * Store a newly created exam in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:classes,id',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'total_score' => 'required|numeric|min:1|max:100',
            'publish' => 'boolean',
        ]);

        $teacher = Auth::user()->teacher;

        // Verify the teacher teaches this subject in this class
        $hasAccess = \App\Models\Schedule::where('teacher_id', $teacher->id)
            ->where('subject_id', $request->subject_id)
            ->where('class_id', $request->school_class_id)
            ->exists();

        if (!$hasAccess) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk membuat ujian di kelas dan mata pelajaran ini.');
        }

        Exam::create([
            'name' => $request->name,
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'school_class_id' => $request->school_class_id,
            'teacher_id' => $teacher->id,
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_score' => $request->total_score,
            'publish' => $request->publish ?? false,
        ]);

        return redirect()->route('guru.exams.index')
            ->with('success', 'Ujian berhasil dibuat.');
    }


    /**
     * Display the specified exam.
     */
    public function show(Exam $exam)
    {
        $teacher = Auth::user()->teacher;

        // Verify the exam belongs to this teacher
        if ($exam->teacher_id !== $teacher->id) {
            abort(403);
        }

        $exam->load(['subject', 'schoolClass', 'teacher']);


        // Get grades for this exam
        $grades = \App\Models\Grade::where('exam_id', $exam->id)
            ->join('students', 'grades.student_id', '=', 'students.id')
            ->select('grades.*', 'students.name as student_name')
            ->orderBy('students.name')
            ->get();

        // Load the student relationship for each grade
        $grades->load('student');

        return view('guru.exams.show', compact('exam', 'grades'));
    }

    /**
     * Show the form for editing the specified exam.
     */
    public function edit(Exam $exam)
    {
        $teacher = Auth::user()->teacher;

        // Verify the exam belongs to this teacher
        if ($exam->teacher_id !== $teacher->id) {
            abort(403);
        }

        // Get classes taught by this teacher
        $classes = \App\Models\SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        // Get subjects taught by this teacher
        $subjects = \App\Models\Subject::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        return view('guru.exams.edit', compact('exam', 'classes', 'subjects'));
    }

    /**
     * Update the specified exam in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        $teacher = Auth::user()->teacher;

        // Verify the exam belongs to this teacher
        if ($exam->teacher_id !== $teacher->id) {
            abort(403);
        }


        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:classes,id',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'total_score' => 'required|numeric|min:1|max:100',
            'publish' => 'boolean',
        ]);

        // Verify the teacher teaches this subject in this class
        $hasAccess = \App\Models\Schedule::where('teacher_id', $teacher->id)
            ->where('subject_id', $request->subject_id)
            ->where('class_id', $request->school_class_id)
            ->exists();

        if (!$hasAccess) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengupdate ujian di kelas dan mata pelajaran ini.');
        }

        $exam->update([
            'name' => $request->name,
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'school_class_id' => $request->school_class_id,
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_score' => $request->total_score,
            'publish' => $request->publish ?? false,
        ]);

        return redirect()->route('guru.exams.index')
            ->with('success', 'Ujian berhasil diperbarui.');
    }

    /**
     * Remove the specified exam from storage.
     */
    public function destroy(Exam $exam)
    {
        $teacher = Auth::user()->teacher;

        // Verify the exam belongs to this teacher
        if ($exam->teacher_id !== $teacher->id) {
            abort(403);
        }

        // Delete associated grades
        \App\Models\Grade::where('exam_id', $exam->id)->delete();

        $exam->delete();

        return redirect()->route('guru.exams.index')
            ->with('success', 'Ujian berhasil dihapus.');
    }

    /**
     * Get teachers by class for AJAX requests.
     */
    public function getTeachersByClass($classId)
    {
        $teachers = \App\Models\Teacher::whereHas('schedules', function ($query) use ($classId) {
            $query->where('class_id', $classId);
        })->with('user')->get();

        return response()->json($teachers);
    }


    /**
     * Get subjects by teacher for AJAX requests.
     */
    public function getSubjectsByTeacher($teacherId)
    {
        $subjects = \App\Models\Subject::whereHas('schedules', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();

        return response()->json($subjects);
    }

    /**
     * Get subjects by class for AJAX requests.
     */
    public function getSubjectsByClass($classId)
    {
        $teacher = Auth::user()->teacher;
        
        // Get subjects taught by this teacher in the specified class
        $subjects = \App\Models\Subject::whereHas('schedules', function ($query) use ($teacher, $classId) {
            $query->where('teacher_id', $teacher->id)
                  ->where('class_id', $classId);
        })->get();

        return response()->json($subjects);
    }
}
