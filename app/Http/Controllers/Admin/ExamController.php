<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::with(['subject', 'schoolClass', 'teacher'])->paginate(10);

        return view('admin.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        $schoolClasses = SchoolClass::all();
        $teachers = Teacher::all();

        return view('admin.exams.create', compact('subjects', 'schoolClasses', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'school_class_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:teachers,id',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_score' => 'required|numeric|min:0|max:999.99',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Exam::create($request->all());

        return redirect()->route('admin.exams.index')
            ->with('success', 'Ujian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        $exam->load(['subject', 'schoolClass', 'teacher', 'grades.student']);

        return view('admin.exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        $subjects = Subject::all();
        $schoolClasses = SchoolClass::all();
        $teachers = Teacher::all();

        return view('admin.exams.edit', compact('exam', 'subjects', 'schoolClasses', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'school_class_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_score' => 'required|numeric|min:0|max:999.99',
            'description' => 'nullable|string',
            'publish' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $exam->update($request->all());

        return redirect()->route('admin.exams.index')
            ->with('success', 'Ujian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('admin.exams.index')
            ->with('success', 'Ujian berhasil dihapus.');
    }

    /**
     * Get teachers by class ID for AJAX
     */
    public function getTeachersByClass($classId)
    {
        $teachers = Teacher::whereHas('schedules', function($query) use ($classId) {
            $query->where('class_id', $classId);
        })->distinct()->get(['id', 'name']);

        return response()->json($teachers);
    }

    /**
     * Get subjects by teacher and class ID for AJAX
     */
    public function getSubjectsByTeacher($teacherId, Request $request)
    {
        $classId = $request->get('class_id');

        if (!$classId) {
            return response()->json([]);
        }

        $subjects = Subject::whereHas('schedules', function($query) use ($teacherId, $classId) {
            $query->where('teacher_id', $teacherId)
                  ->where('class_id', $classId);
        })->distinct()->get(['id', 'name']);

        return response()->json($subjects);
    }
}
