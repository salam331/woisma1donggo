<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Grade::with(['student.class', 'subject', 'exam']);

    // 🔥 Filter berdasarkan kelas jika dipilih
    if ($request->class_id) {
        $query->whereHas('student', function($q) use ($request) {
            $q->where('school_class_id', $request->class_id);
        });
    }

    $grades = $query->get()
        ->groupBy(function($grade) {
            return $grade->student->school_class_id ?? 0;
        })
        ->sortKeys();

    $schoolClasses = SchoolClass::all();

    // Get class names for display
    $classNames = SchoolClass::whereIn('id', $grades->keys())->pluck('name', 'id');

    return view('admin.grades.index', compact('grades', 'schoolClasses', 'classNames'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolClasses = SchoolClass::all();

        return view('admin.grades.create', compact('schoolClasses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_id' => 'required|exists:exams,id',
            'grades' => 'required|array',
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.score' => 'required|numeric|min:0|max:100',
            'grades.*.grade_letter' => 'required|string|max:5',
            'grades.*.notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->grades as $gradeData) {
            Grade::create([
                'student_id' => $gradeData['student_id'],
                'subject_id' => $request->subject_id,
                'exam_id' => $request->exam_id,
                'score' => $gradeData['score'],
                'grade_letter' => $gradeData['grade_letter'],
                'notes' => $gradeData['notes'] ?? null,
            ]);
        }

        return redirect()->route('admin.grades.index')
            ->with('success', 'Nilai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        $grade->load(['student', 'subject', 'exam']);

        return view('admin.grades.show', compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        $students = Student::all();
        $subjects = Subject::all();
        $exams = Exam::all();

        // Tambahan yang hilang
        $schoolClasses = SchoolClass::all();

        return view('admin.grades.edit', compact(
            'grade',
            'students',
            'subjects',
            'exams',
            'schoolClasses'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_id' => 'required|exists:exams,id',
            'score' => 'required|numeric|min:0|max:100',
            'grade_letter' => 'required|string|max:5',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $grade->update($request->all());

        return redirect()->route('admin.grades.index')
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('admin.grades.index')
            ->with('success', 'Nilai berhasil dihapus.');
    }

    /**
     * Get subjects by class ID for AJAX request.
     */
    public function getSubjectsByClass($classId)
    {
        $subjects = Schedule::where('class_id', $classId)
            ->with('subject')
            ->get()
            ->pluck('subject')
            ->unique('id')
            ->values();

        return response()->json($subjects);
    }

    /**
     * Get exams by class ID and subject ID for AJAX request.
     */
    public function getExamsByClassAndSubject($classId, $subjectId)
    {
        $exams = Exam::where('school_class_id', $classId)
            ->where('subject_id', $subjectId)
            ->get();

        return response()->json($exams);
    }

    /**
     * Get students by class ID for AJAX request.
     */
    public function getStudentsByClass($classId)
    {
        $students = Student::where('school_class_id', $classId)->get();

        return response()->json($students);
    }

    /**
     * Show subjects for a specific class.
     */
    public function showClass($classId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);

        $subjects = Schedule::where('class_id', $classId)
            ->with('subject')
            ->get()
            ->pluck('subject')
            ->unique('id')
            ->sortBy('name');

        return view('admin.grades.class', compact('schoolClass', 'subjects'));
    }

    /**
     * Show exams for a specific class and subject.
     */
    public function showSubject($classId, $subjectId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        $subject = Subject::findOrFail($subjectId);

        $exams = Exam::where('school_class_id', $classId)
            ->where('subject_id', $subjectId)
            ->orderBy('name')
            ->get();

        return view('admin.grades.subject', compact('schoolClass', 'subject', 'exams'));
    }

    /**
     * Show students and their grades for a specific exam.
     */
    public function showExam($classId, $subjectId, $examId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        $subject = Subject::findOrFail($subjectId);
        $exam = Exam::findOrFail($examId);

        $grades = Grade::where('exam_id', $examId)
            ->with(['student', 'subject', 'exam'])
            ->get();

        return view('admin.grades.exam', compact('schoolClass', 'subject', 'exam', 'grades'));
    }

    /**
     * Show the form for editing all grades for a specific exam.
     */
    public function editExam($classId, $subjectId, $examId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        $subject = Subject::findOrFail($subjectId);
        $exam = Exam::findOrFail($examId);

        $students = Student::where('school_class_id', $classId)->get();
        $grades = Grade::where('exam_id', $examId)
            ->with(['student', 'subject', 'exam'])
            ->get()
            ->keyBy('student_id');

        return view('admin.grades.edit-exam', compact('schoolClass', 'subject', 'exam', 'students', 'grades'));
    }

    /**
     * Update all grades for a specific exam.
     */
    public function updateExam(Request $request, $classId, $subjectId, $examId)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*.score' => 'required|numeric|min:0|max:100',
            'grades.*.grade_letter' => 'required|string|max:5',
            'grades.*.notes' => 'nullable|string|max:500',
        ]);

        foreach ($request->grades as $studentId => $gradeData) {
            Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'exam_id' => $examId,
                ],
                [
                    'subject_id' => $subjectId,
                    'score' => $gradeData['score'],
                    'grade_letter' => $gradeData['grade_letter'],
                    'notes' => $gradeData['notes'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.grades.exam', [$classId, $subjectId, $examId])
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Show detailed grade for a specific student in an exam.
     */
    public function showStudent($classId, $subjectId, $examId, $studentId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        $subject = Subject::findOrFail($subjectId);
        $exam = Exam::findOrFail($examId);
        $student = Student::findOrFail($studentId);

        $grade = Grade::where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->with(['student', 'subject', 'exam'])
            ->first();

        return view('admin.grades.student', compact('schoolClass', 'subject', 'exam', 'student', 'grade'));
    }
}
