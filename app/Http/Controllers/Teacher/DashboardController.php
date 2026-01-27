<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // Standarisasi hari (WAJIB)
        $today = strtolower($now->format('l')); 
        // hasil: monday, tuesday, ...

        $teacher = auth()->user()->teacher;

        /**
         * ===============================
         * 1️⃣ Jadwal hari ini (SEMUA)
         * ===============================
         */
        $today_schedule = Schedule::with(['subject', 'class'])
            ->where('teacher_id', $teacher->id)
            ->whereRaw('LOWER(day) = ?', [$today])
            ->orderBy('start_time')
            ->get()
            ->map(function ($schedule) use ($now) {

                // Tambahkan status jadwal (opsional tapi sangat berguna)
                $currentTime = $now->format('H:i');

                if ($currentTime < $schedule->start_time->format('H:i')) {
                    $schedule->status = 'akan_datang';
                } elseif ($currentTime > $schedule->end_time->format('H:i')) {
                    $schedule->status = 'selesai';
                } else {
                    $schedule->status = 'berlangsung';
                }

                return $schedule;
            });

        /**
         * ===============================
         * 2️⃣ Jumlah kelas unik
         * ===============================
         */
        $classes_count = Schedule::where('teacher_id', $teacher->id)
            ->distinct('class_id')
            ->count('class_id');

        /**
         * ===============================
         * 3️⃣ Jumlah ujian (BENAR)
         * ===============================
         * Ambil langsung dari exam.teacher_id
         */
        $exams_count = $teacher->exams()->count();

        /**
         * ===============================
         * 4️⃣ Jumlah materi
         * ===============================
         */
        $materials_uploaded = $teacher->materials()->count();

        return view('guru.dashboard', compact(
            'today_schedule',
            'classes_count',
            'exams_count',
            'materials_uploaded'
        ));
    }
}
