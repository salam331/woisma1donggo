<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
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
        $materials = Material::with(['subject', 'teacher'])->paginate(10);
        return view('admin.materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('admin.materials.create', compact('subjects', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,avi,mov|max:10240',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('materials', 'public');
        $fileType = $file->getClientMimeType();

        Material::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
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
        return view('admin.materials.edit', compact('material', 'subjects', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,gif,mp4,avi,mov|max:10240',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $data = $request->only(['title', 'description', 'subject_id', 'teacher_id']);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($material->file_path);
            $file = $request->file('file');
            $data['file_path'] = $file->store('materials', 'public');
            $data['file_type'] = $file->getClientMimeType();
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
}
