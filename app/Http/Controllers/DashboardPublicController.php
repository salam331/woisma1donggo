<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Gallery;
use Illuminate\Http\Request;

class DashboardPublicController extends Controller
{
    /**
     * Display the public dashboard with real-time statistics.
     */
    public function index()
    {
        $statistics = [
            [
                'label' => 'Siswa Aktif',
                'count' => Student::count(),
            ],
            [
                'label' => 'Guru & Staff',
                'count' => Teacher::count(),
            ],
            [
                'label' => 'Kelas',
                'count' => SchoolClass::count(),
            ],
            [
                'label' => 'Prestasi',
                'count' => Gallery::count(),
            ],
        ];

        return view('dashboard', compact('statistics'));
    }
}

