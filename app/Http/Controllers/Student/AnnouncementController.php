<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('is_active', true)
            ->whereIn('target', ['siswa', 'semua', 'publik'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('siswa.announcements.index', compact('announcements'));
    }
}
