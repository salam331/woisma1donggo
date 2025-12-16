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
        ->withCount(['students'])
        ->get()
        ->map(function ($class) use ($teacher) {
            // Get schedules for this class taught by this teacher
            $teacherSchedules = $class->schedules->where('teacher_id', $teacher->id);
            
            // Calculate statistics based on teacher's schedules in this class
            $totalStudents = $class->students->count();
            $teacherSchedulesCount = $teacherSchedules->count();
            
            // Get materials count for this class's subjects taught by this teacher
            $materialsCount = \App\Models\Material::whereHas('subject', function ($query) use ($teacher, $class) {
                $query->where('teacher_id', $teacher->id)
                      ->whereHas('schedules', function ($q) use ($class, $teacher) {
                          $q->where('class_id', $class->id)
                            ->where('teacher_id', $teacher->id);
                      });
            })->count();
            
            // Get exams count for this class taught by this teacher
            $examsCount = \App\Models\Exam::whereHas('subject', function ($query) use ($teacher, $class) {
                $query->where('teacher_id', $teacher->id)
                      ->whereHas('schedules', function ($q) use ($class, $teacher) {
                          $q->where('class_id', $class->id)
                            ->where('teacher_id', $teacher->id);
                      });
            })->where('school_class_id', $class->id)->count();

            $class->statistics = [
                'total_students' => $totalStudents,
                'total_schedules' => $teacherSchedulesCount,
                'materials_count' => $materialsCount,
                'exams_count' => $examsCount,
            ];

            $class->teacher_schedules = $teacherSchedules;

            return $class;
        })
        ->sortBy(function ($class) {
            return $class->grade_level . $class->name;
        });

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
