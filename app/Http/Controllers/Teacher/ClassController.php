<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{


    /**
     * Display a listing of the classes assigned to the authenticated teacher.
     */
    public function index()
    {
        // Get the authenticated teacher
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Get classes where this teacher teaches subjects based on schedules
        $classes = SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })
        ->with(['students', 'schedules.subject'])
        ->get()
        ->map(function ($class) use ($teacher) {

            $teacherSchedules = $class->schedules->where('teacher_id', $teacher->id);

            $class->statistics = [
                'total_students'   => $class->students->count(),
                'total_schedules'  => $teacherSchedules->count(),

                'materials_count'  => \App\Models\Material::where('class_id', $class->id)
                    ->where('teacher_id', $teacher->id)
                    ->count(),

                'exams_count' => \App\Models\Exam::where('school_class_id', $class->id)
                    ->where('teacher_id', $teacher->id)
                    ->count(),

            ];

            return $class;
        })
        ->sortBy(fn ($class) => $class->grade_level . $class->name);


        return view('guru.classes.index', compact('classes'));
    }


    /**
     * Display the specified class.
     */
    public function show(SchoolClass $class)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Verify the teacher teaches this class (based on schedules, not as homeroom teacher)
        $hasSchedules = $class->schedules()->where('teacher_id', $teacher->id)->exists();
        
        if (!$hasSchedules) {
            abort(403);
        }

        $class->load(['students', 'schedules.subject', 'schedules.teacher']);

        // Filter schedules to only show this teacher's schedules
        $class->teacher_schedules = $class->schedules->where('teacher_id', $teacher->id);

        return view('guru.classes.show', compact('class'));
    }


    /**
     * Show students of a specific class.
     */
    public function students(SchoolClass $class)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Verify the teacher teaches this class (based on schedules, not as homeroom teacher)
        $hasSchedules = $class->schedules()->where('teacher_id', $teacher->id)->exists();
        
        if (!$hasSchedules) {
            abort(403);
        }

        $students = $class->students()
            ->with(['grades' => function ($query) use ($teacher) {
                $query->whereHas('exam', function ($q) use ($teacher) {
                    $q->whereHas('subject', function ($sq) use ($teacher) {
                        $sq->where('teacher_id', $teacher->id);
                    });
                });
            }])
            ->get();


        return view('guru.classes.students', compact('class', 'students'));
    }

    /**
     * Get students of a specific class in JSON format (for AJAX requests).
     */
    public function studentsJson(SchoolClass $class)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return response()->json(['error' => 'Data guru tidak ditemukan.'], 403);
        }

        // Verify the teacher teaches this class (based on schedules, not as homeroom teacher)
        $hasSchedules = $class->schedules()->where('teacher_id', $teacher->id)->exists();
        
        if (!$hasSchedules) {
            return response()->json(['error' => 'Anda tidak memiliki akses ke kelas ini.'], 403);
        }

        $students = $class->students()
            ->select('id', 'name', 'nis')
            ->orderBy('name')
            ->get();

        return response()->json([
            'students' => $students,
            'class' => [
                'id' => $class->id,
                'name' => $class->name
            ]
        ]);
    }
}
