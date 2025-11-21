<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = SchoolClass::with('teacher')->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::all();
        return view('admin.classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_level' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'description' => 'nullable|string',
        ]);

        SchoolClass::create($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $class)
    {
        $class->load('teacher');
        return view('admin.classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $class)
    {
        $teachers = Teacher::all();
        return view('admin.classes.edit', compact('class', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_level' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'description' => 'nullable|string',
        ]);

        $class->update($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }

    /**
     * Get students for a specific class.
     */
    public function students(SchoolClass $class)
    {
        $students = $class->students()->select('id', 'nis', 'name')->get();
        return response()->json(['students' => $students]);
    }
}
