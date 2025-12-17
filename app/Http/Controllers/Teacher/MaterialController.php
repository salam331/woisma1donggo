<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Display a listing of the materials for the authenticated teacher.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }

        $materials = Material::where('teacher_id', $teacher->id)
            ->with(['subject', 'class'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('guru.materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new material.
     */
    public function create()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect()->route('guru.dashboard')->with('error', 'Data guru tidak ditemukan.');
        }


        // Get classes taught by this teacher
        $classes = \App\Models\SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        // Get subjects taught by this teacher
        $subjects = \App\Models\Subject::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        return view('guru.materials.create', compact('classes', 'subjects'));
    }

    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,avi,mov|max:51200', // 50MB max
            'is_public' => 'boolean',
        ]);

        $teacher = Auth::user()->teacher;

        // Verify the teacher teaches this subject in this class
        $hasAccess = \App\Models\Schedule::where('teacher_id', $teacher->id)
            ->where('subject_id', $request->subject_id)
            ->where('class_id', $request->class_id)
            ->exists();

        if (!$hasAccess) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengupload materi ke kelas dan mata pelajaran ini.');
        }

        $filePath = $request->file('file')->store('materials', 'public');


        // Determine file type based on MIME type
        $mimeType = $request->file('file')->getMimeType();
        $fileType = $this->getFileTypeFromMimeType($mimeType);

        Material::create([
            'title' => $request->title,
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'teacher_id' => $teacher->id,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_size' => $request->file('file')->getSize(),
            'mime_type' => $mimeType,
            'is_public' => $request->boolean('is_public'),
        ]);

        return redirect()->route('guru.materials.index')
            ->with('success', 'Materi berhasil diupload.');
    }

    /**
     * Display the specified material.
     */
    public function show(Material $material)
    {
        $teacher = Auth::user()->teacher;

        // Verify the material belongs to this teacher
        if ($material->teacher_id !== $teacher->id) {
            abort(403);
        }

        $material->load(['subject', 'class', 'teacher']);

        return view('guru.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified material.
     */
    public function edit(Material $material)
    {
        $teacher = Auth::user()->teacher;

        // Verify the material belongs to this teacher
        if ($material->teacher_id !== $teacher->id) {
            abort(403);
        }

        // Get classes taught by this teacher
        $classes = \App\Models\SchoolClass::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        // Get subjects taught by this teacher
        $subjects = \App\Models\Subject::whereHas('schedules', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->get();

        return view('guru.materials.edit', compact('material', 'classes', 'subjects'));
    }

    /**
     * Update the specified material in storage.
     */
    public function update(Request $request, Material $material)
    {
        $teacher = Auth::user()->teacher;

        // Verify the material belongs to this teacher
        if ($material->teacher_id !== $teacher->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,avi,mov|max:51200',
            'is_public' => 'boolean',
        ]);

        // Verify the teacher teaches this subject in this class
        $hasAccess = \App\Models\Schedule::where('teacher_id', $teacher->id)
            ->where('subject_id', $request->subject_id)
            ->where('class_id', $request->class_id)
            ->exists();

        if (!$hasAccess) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengupdate materi ke kelas dan mata pelajaran ini.');
        }

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'is_public' => $request->boolean('is_public'),
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete($material->file_path);

            $filePath = $request->file('file')->store('materials', 'public');
            $updateData['file_path'] = $filePath;
            $updateData['file_name'] = $request->file('file')->getClientOriginalName();
            $updateData['file_size'] = $request->file('file')->getSize();
            $updateData['mime_type'] = $request->file('file')->getMimeType();
        }

        $material->update($updateData);

        return redirect()->route('guru.materials.index')
            ->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy(Material $material)
    {
        $teacher = Auth::user()->teacher;

        // Verify the material belongs to this teacher
        if ($material->teacher_id !== $teacher->id) {
            abort(403);
        }

        // Delete file from storage
        Storage::disk('public')->delete($material->file_path);

        $material->delete();

        return redirect()->route('guru.materials.index')
            ->with('success', 'Materi berhasil dihapus.');
    }



    /**
     * Download the specified material.
     */
    public function download(Material $material)
    {
        $teacher = Auth::user()->teacher;

        // Verify the material belongs to this teacher or is public
        if ($material->teacher_id !== $teacher->id && !$material->is_public) {
            abort(403);
        }

        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    /**
     * Get subjects for a specific class (AJAX endpoint)
     */
    public function getSubjectsByClass($classId)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get subjects that this teacher teaches in this specific class
        $subjects = \App\Models\Subject::whereHas('schedules', function ($query) use ($teacher, $classId) {
            $query->where('teacher_id', $teacher->id)
                  ->where('class_id', $classId);
        })->get();

        return response()->json($subjects);
    }

    /**
     * Determine file type based on MIME type
     */
    private function getFileTypeFromMimeType($mimeType)
    {
        $fileTypes = [
            // Documents
            'application/pdf' => 'document',
            'application/msword' => 'document',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'document',
            'application/vnd.ms-excel' => 'document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'document',
            'application/vnd.ms-powerpoint' => 'document',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'document',
            'text/plain' => 'document',
            
            // Images
            'image/jpeg' => 'image',
            'image/jpg' => 'image',
            'image/png' => 'image',
            'image/gif' => 'image',
            'image/webp' => 'image',
            'image/svg+xml' => 'image',
            
            // Videos
            'video/mp4' => 'video',
            'video/avi' => 'video',
            'video/mov' => 'video',
            'video/wmv' => 'video',
            'video/quicktime' => 'video',
        ];

        return $fileTypes[$mimeType] ?? 'other';
    }
}
