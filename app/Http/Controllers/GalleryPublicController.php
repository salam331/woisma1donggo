<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryPublicController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('is_active', true)->get();

        return view('gallery', compact('galleries'));
    }

    public function show($id)
{
    $gallery = \App\Models\Gallery::findOrFail($id);

    return view('gallery-detail', compact('gallery'));
}

}
