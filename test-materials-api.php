<?php
/**
 * Script untuk testing API endpoint materials
 * Jalankan: php test-materials-api.php
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Schedule;
use App\Models\Teacher;

echo "=== Testing Materials API Endpoints ===\n\n";

// 1. Cek apakah ada schedule data
echo "1. Checking Schedule Data in Database:\n";
$scheduleCount = Schedule::count();
echo "   Total schedules: $scheduleCount\n\n";

// 2. Cek teacher yang punya schedule
echo "2. Teachers with Schedules:\n";
$teachersWithSchedules = Schedule::with('teacher')
    ->select('teacher_id')
    ->distinct()
    ->get()
    ->pluck('teacher.name', 'teacher_id');

if ($teachersWithSchedules->isEmpty()) {
    echo "   ❌ NO TEACHERS FOUND WITH SCHEDULES!\n";
    echo "   This is the problem! Please add schedule data first.\n\n";
} else {
    foreach ($teachersWithSchedules as $teacherId => $teacherName) {
        echo "   - Teacher ID: $teacherId, Name: $teacherName\n";
    }
    echo "\n";
}

// 3. Test getClassesByTeacher logic untuk teacher pertama
if ($teachersWithSchedules->isNotEmpty()) {
    $firstTeacherId = $teachersWithSchedules->keys()->first();
    echo "3. Testing getClassesByTeacher Logic (Teacher ID: $firstTeacherId):\n";
    
    $classes = Schedule::where('teacher_id', $firstTeacherId)
        ->with('class')
        ->select('class_id')
        ->distinct()
        ->get()
        ->map(function ($schedule) {
            return [
                'id' => $schedule->class->id,
                'name' => $schedule->class->name,
            ];
        })
        ->values();
    
    if ($classes->isEmpty()) {
        echo "   ❌ NO CLASSES RETURNED!\n";
    } else {
        echo "   ✓ Classes found:\n";
        foreach ($classes as $class) {
            echo "     - ID: {$class['id']}, Name: {$class['name']}\n";
        }
    }
    echo "\n";
    
    // 4. Test getSubjectsByTeacherClass logic
    if ($classes->isNotEmpty()) {
        $firstClassId = $classes->first()['id'];
        echo "4. Testing getSubjectsByTeacherClass Logic (Teacher ID: $firstTeacherId, Class ID: $firstClassId):\n";
        
        $subjects = Schedule::where('teacher_id', $firstTeacherId)
            ->where('class_id', $firstClassId)
            ->with('subject')
            ->select('subject_id')
            ->distinct()
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->subject->id,
                    'name' => $schedule->subject->name,
                ];
            })
            ->values();
        
        if ($subjects->isEmpty()) {
            echo "   ❌ NO SUBJECTS RETURNED!\n";
        } else {
            echo "   ✓ Subjects found:\n";
            foreach ($subjects as $subject) {
                echo "     - ID: {$subject['id']}, Name: {$subject['name']}\n";
            }
        }
    }
}

echo "\n=== END OF TEST ===\n";
