<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::with(['subject', 'teacher', 'class'])->paginate(10);
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classes = SchoolClass::all();
        return view('admin.materials.index', compact('materials', 'subjects', 'teachers', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classes = SchoolClass::all();
        return view('admin.materials.create', compact('subjects', 'teachers', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,avi,mov|max:51200',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
            'is_public' => 'boolean',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('materials', 'public');
        $mimeType = $file->getClientMimeType();

        $fileType = match (true) {
            str_starts_with($mimeType, 'image/') => 'image',
            str_starts_with($mimeType, 'video/') => 'video',
            str_starts_with($mimeType, 'audio/') => 'audio',
            default => 'document',
        };

        Material::create([
            'title' => $request->title,
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'class_id' => $request->class_id,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $mimeType,
            'file_type' => $fileType,
            'is_public' => $request->boolean('is_public'),
        ]);

        return redirect()->route('admin.materials.index')->with('success', 'Material created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        $material->load(['subject', 'teacher']);
        return view('admin.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classes = SchoolClass::all();
        return view('admin.materials.edit', compact('material', 'subjects', 'teachers', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,avi,mov|max:51200',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
            'is_public' => 'boolean',
        ]);

        $data = $request->only(['title', 'description', 'subject_id', 'teacher_id', 'class_id', 'is_public']);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($material->file_path);
            $file = $request->file('file');
            $data['file_path'] = $file->store('materials', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getClientMimeType();
            
            $mimeType = $file->getClientMimeType();

            $data['mime_type'] = $mimeType;
            $data['file_type'] = match (true) {
                str_starts_with($mimeType, 'image/') => 'image',
                str_starts_with($mimeType, 'video/') => 'video',
                str_starts_with($mimeType, 'audio/') => 'audio',
                default => 'document',
            };
        }

        $material->update($data);

        return redirect()->route('admin.materials.index')->with('success', 'Material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        Storage::disk('public')->delete($material->file_path);
        $material->delete();

        return redirect()->route('admin.materials.index')->with('success', 'Material deleted successfully.');
    }

    /**
     * Download the material file.
     */
    public function download(Material $material)
    {
        return Storage::disk('public')->download($material->file_path);
    }

    /**
     * Get classes by teacher ID
     * Endpoint: GET /admin/materials/get-classes-by-teacher/{teacher_id}
     */
    public function getClassesByTeacher($teacherId)
    {
        try {
            $classes = Schedule::where('teacher_id', $teacherId)
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

            return response()->json($classes);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get subjects by teacher ID and class ID
     * Endpoint: GET /admin/materials/get-subjects-by-teacher-class/{teacher_id}/{class_id}
     */
    public function getSubjectsByTeacherClass($teacherId, $classId)
    {
        try {
            $subjects = Schedule::where('teacher_id', $teacherId)
                ->where('class_id', $classId)
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

            return response()->json($subjects);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
