<?php

namespace App\Http\Controllers;

use App\Models\SchoolProfile;
use Illuminate\Http\Request;

class SchoolProfilePublicController extends Controller
{
    public function show()
    {
        $profile = SchoolProfile::first();
        if (!$profile) {
            $profile = SchoolProfile::create(['name' => 'SMAN 1 Donggo']);
        }
        return view('about', compact('profile'));
    }
}
