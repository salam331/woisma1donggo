<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Display a listing of the grades managed by the authenticated teacher.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Get classes taught by this teacher
        $classes = \App\Models\SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with('teacher')->get();

        return view('guru.grades.index', compact('classes'));
    }

    /**
     * Show grades for a specific class.
     */
    public function showClass($classId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $class = \App\Models\SchoolClass::findOrFail($classId);

        // Verify the teacher teaches this class
        $hasAccess = \App\Models\Schedule::where('teacher_id', $teacher->id)
            ->where('class_id', $classId)
            ->exists();

        if (!$hasAccess) {
            abort(403);
        }

        // Get subjects taught by this teacher in this class
        $subjects = \App\Models\Subject::whereHas('schedules', function ($query) use ($teacher, $classId) {
            $query->where('teacher_id', $teacher->id)
                  ->where('class_id', $classId);
        })->get();

        return view('guru.grades.class', compact('class', 'subjects'));
    }

    /**
     * Show grades for a specific subject in a class.
     */
    public function showSubject($classId, $subjectId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $class = \App\Models\SchoolClass::findOrFail($classId);
        $subject = \App\Models\Subject::findOrFail($subjectId);

        // Verify the teacher teaches this subject in this class
        $hasAccess = \App\Models\Schedule::where('teacher_id', $teacher->id)
            ->where('subject_id', $subjectId)
            ->where('class_id', $classId)
            ->exists();

        if (!$hasAccess) {
            abort(403);
        }


        // Get exams for this class and subject
        $exams = Exam::where('school_class_id', $classId)
            ->where('subject_id', $subjectId)
            ->where('teacher_id', $teacher->id)
            ->orderBy('exam_date', 'desc')
            ->get();

        return view('guru.grades.subject', compact('class', 'subject', 'exams'));
    }

    /**
     * Show grades for a specific exam.
     */
    public function showExam($classId, $subjectId, $examId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $class = \App\Models\SchoolClass::findOrFail($classId);
        $subject = \App\Models\Subject::findOrFail($subjectId);
        $exam = Exam::findOrFail($examId);


        // Verify the exam belongs to this teacher and class/subject
        if ($exam->teacher_id !== $teacher->id || $exam->school_class_id != $classId || $exam->subject_id != $subjectId) {
            abort(403);
        }


        $exam->load(['schoolClass', 'subject', 'teacher']);

        // Get all students in the class
        $students = $class->students()->orderBy('name')->get();

        // Get existing grades for this exam
        $grades = Grade::where('exam_id', $examId)
            ->with('student')
            ->get()
            ->keyBy('student_id');

        return view('guru.grades.exam', compact('class', 'subject', 'exam', 'students', 'grades'));
    }

    /**
     * Show the form for editing exam grades.
     */
    public function editExam($classId, $subjectId, $examId)
    {
        return $this->showExam($classId, $subjectId, $examId);
    }

    /**
     * Update exam grades.
     */
    public function updateExam(Request $request, $classId, $subjectId, $examId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $exam = Exam::findOrFail($examId);

        // Verify the exam belongs to this teacher
        if ($exam->teacher_id !== $teacher->id) {
            abort(403);
        }

        $request->validate([
            'grades' => 'required|array',
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.score' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($request->grades as $gradeData) {
            Grade::updateOrCreate(
                [
                    'exam_id' => $examId,
                    'student_id' => $gradeData['student_id'],
                ],
                [
                    'score' => $gradeData['score'],
                ]
            );
        }

        return redirect()->route('guru.grades.exam', [$classId, $subjectId, $examId])
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Show grades for a specific student.
     */
    public function showStudent($classId, $subjectId, $examId, $studentId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $class = \App\Models\SchoolClass::findOrFail($classId);
        $subject = \App\Models\Subject::findOrFail($subjectId);
        $exam = Exam::findOrFail($examId);
        $student = \App\Models\Student::findOrFail($studentId);

        // Verify the exam belongs to this teacher
        if ($exam->teacher_id !== $teacher->id) {
            abort(403);
        }

        // Verify the student is in the class
        if ($student->school_class_id != $classId) {
            abort(403);
        }

        $grade = Grade::where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->first();

        return view('guru.grades.student', compact('class', 'subject', 'exam', 'student', 'grade'));
    }

    /**
     * Get subjects by class for AJAX requests.
     */
    public function getSubjectsByClass($classId)
    {
        $teacher = Auth::user()->teacher;

        $subjects = \App\Models\Subject::whereHas('schedules', function ($query) use ($teacher, $classId) {
            $query->where('teacher_id', $teacher->id)
                  ->where('class_id', $classId);
        })->get();

        return response()->json($subjects);
    }

    /**
     * Get exams by class and subject for AJAX requests.
     */
    public function getExamsByClassAndSubject($classId, $subjectId)
    {
        $teacher = Auth::user()->teacher;


        $exams = Exam::where('school_class_id', $classId)
            ->where('subject_id', $subjectId)
            ->where('teacher_id', $teacher->id)
            ->orderBy('exam_date', 'desc')
            ->get();

        return response()->json($exams);
    }

    /**
     * Get students by class for AJAX requests.
     */
    public function getStudentsByClass($classId)
    {
        $class = \App\Models\SchoolClass::findOrFail($classId);

        $students = $class->students()->orderBy('name')->get();

        return response()->json($students);
    }
}
