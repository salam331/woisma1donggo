<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $grades = Grade::where('student_id', $student->id)
            ->with(['subject', 'exam'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.grades.index', compact('grades'));
    }


    public function subjects()
    {
        $student = Auth::user()->student;

        // Get unique subjects with their grades for this student
        $grades = Grade::where('student_id', $student->id)
            ->with(['subject', 'exam'])
            ->get();

        $subjectData = [];
        
        if ($grades->isNotEmpty()) {
            $subjectGrades = $grades->groupBy('subject_id');
            
            foreach ($subjectGrades as $subjectId => $subjectGradeList) {
                $subject = $subjectGradeList->first()->subject;
                $totalExams = $subjectGradeList->count();
                $averageScore = $subjectGradeList->avg('score');
                $maxScore = $subjectGradeList->max('score');
                $minScore = $subjectGradeList->min('score');
                
                // Determine status based on average score
                if ($averageScore >= 85) {
                    $status = 'Sangat Baik';
                    $statusColor = 'green';
                } elseif ($averageScore >= 70) {
                    $status = 'Baik';
                    $statusColor = 'yellow';
                } else {
                    $status = 'Perlu Perbaikan';
                    $statusColor = 'red';
                }

                $subjectData[] = [
                    'subject' => $subject,
                    'total_exams' => $totalExams,
                    'average_score' => round($averageScore, 1),
                    'max_score' => $maxScore,
                    'min_score' => $minScore,
                    'status' => $status,
                    'status_color' => $statusColor,
                    'grades' => $subjectGradeList->sortByDesc('created_at')
                ];
            }
        }

        return view('siswa.grades.subjects', compact('subjectData'));
    }

    public function showSubject($subjectId)
    {
        $student = Auth::user()->student;

        $subject = Subject::findOrFail($subjectId);
        
        $grades = Grade::where('student_id', $student->id)
            ->where('subject_id', $subjectId)
            ->with(['exam'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $totalExams = $grades->count();
        $averageScore = $grades->avg('score');
        $maxScore = $grades->max('score');
        $minScore = $grades->min('score');

        return view('siswa.grades.index', compact('grades', 'subject', 'totalExams', 'averageScore', 'maxScore', 'minScore'));
    }
}
