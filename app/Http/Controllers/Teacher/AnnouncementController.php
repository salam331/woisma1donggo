<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements created by admin that are visible to teachers.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Show announcements that are:
        // 1. Active (is_active = true)
        // 2. Targeted to: 'guru', 'semua', or 'publik'
        $announcements = Announcement::where('is_active', true)
            ->whereIn('target', ['guru', 'semua', 'publik'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('guru.announcements.index', compact('announcements'));
    }

    /**
     * Display the specified announcement.
     */
    public function show(Announcement $announcement)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        // Check if the teacher is allowed to view this announcement
        if (!$announcement->is_active || !in_array($announcement->target, ['guru', 'semua', 'publik'])) {
            abort(403, 'Anda tidak memiliki akses untuk melihat pengumuman ini.');
        }

        $announcement->load(['teacher', 'class']);

        return view('guru.announcements.show', compact('announcement'));
    }

    // Removed create, store, edit, update, and destroy methods
    // Only admins can create, edit, and delete announcements
}

