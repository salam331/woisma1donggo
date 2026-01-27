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
    public function index(Request $request)
    {
        $query = SchoolClass::with('teacher');

        // SEARCH NAMA KELAS
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
            // berdasarkan relasi wali kelas
            $query->orWhereHas('teacher', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER TINGKAT KELAS
        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->grade_level);
        }

        // FILTER WALI KELAS
        if ($request->filled('teacher')) {
            if ($request->teacher === 'with') {
                $query->whereNotNull('teacher_id');
            } elseif ($request->teacher === 'without') {
                $query->whereNull('teacher_id');
            }
        }

        $classes = $query->paginate(10)->withQueryString();

        // Ambil daftar tingkat unik untuk dropdown
        $gradeLevels = SchoolClass::select('grade_level')
            ->distinct()
            ->orderBy('grade_level')
            ->pluck('grade_level');

        return view('admin.classes.index', compact('classes', 'gradeLevels'));
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
