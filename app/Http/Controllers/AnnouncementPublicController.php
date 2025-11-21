<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementPublicController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('is_active', 1)
            ->whereIn('target', ['publik', 'semua'])
            ->orderBy('publish_date', 'desc')
            ->get();

        return view('announcements', compact('announcements'));
    }
}
