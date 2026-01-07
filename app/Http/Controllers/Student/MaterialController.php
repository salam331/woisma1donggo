<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        if (!$student || !$student->school_class_id) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data kelas tidak ditemukan.');
        }

        $materials = Material::where('class_id', $student->school_class_id)
            ->where('is_public', true) // Only show public materials
            ->with(['subject', 'teacher'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('siswa.materials.index', compact('materials'));
    }

    public function download(Material $material)
    {
        $student = Auth::user()->student;

        // Verify the material belongs to the student's class
        if ($material->class_id !== $student->school_class_id) {
            abort(403);
        }

        // Only allow download if material is public
        if (!$material->is_public) {
            abort(403);
        }

        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }
}
