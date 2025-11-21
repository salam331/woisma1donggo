<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::with(['class', 'subject', 'teacher'])->paginate(10);
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('admin.schedules.create', compact('classes', 'subjects', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Schedule::create($request->all());

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        $schedule->load(['class', 'subject', 'teacher']);
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('admin.schedules.edit', compact('schedule', 'classes', 'subjects', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $schedule->update($request->all());

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
