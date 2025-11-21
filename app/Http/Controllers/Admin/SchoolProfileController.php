<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = SchoolProfile::first();
        if (!$profile) {
            $profile = SchoolProfile::create(['name' => 'SMAN 1 Donggo']);
        }
        return view('admin.school-profiles.index', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.school-profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        SchoolProfile::create($data);

        return redirect()->route('admin.school-profiles.index')->with('success', 'School profile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolProfile $schoolProfile)
    {
        return view('admin.school-profiles.show', compact('schoolProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolProfile $schoolProfile)
    {
        return view('admin.school-profiles.edit', compact('schoolProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolProfile $schoolProfile)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'principal_name' => 'nullable|string|max:255',
            'history' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($schoolProfile->logo) {
                Storage::disk('public')->delete($schoolProfile->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $schoolProfile->update($data);

        return redirect()->route('admin.school-profiles.index')->with('success', 'School profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolProfile $schoolProfile)
    {
        if ($schoolProfile->logo) {
            Storage::disk('public')->delete($schoolProfile->logo);
        }

        $schoolProfile->delete();

        return redirect()->route('admin.school-profiles.index')->with('success', 'School profile deleted successfully.');
    }
}
