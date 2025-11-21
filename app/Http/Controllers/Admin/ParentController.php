<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = ParentModel::paginate(10);
        return view('admin.parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.parents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|unique:parents',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'relationship' => 'required|in:father,mother,guardian',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role 'orang_tua'
        $user->assignRole('orang_tua');

        $data = $request->all();
        $data['user_id'] = $user->id;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('parents', 'public');
        }

        ParentModel::create($data);

        return redirect()->route('admin.parents.index')->with('success', 'Orang tua berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentModel $parent)
    {
        return view('admin.parents.show', compact('parent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentModel $parent)
    {
        return view('admin.parents.edit', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParentModel $parent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:parents,email,' . $parent->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'relationship' => 'required|in:father,mother,guardian',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            if ($parent->photo) {
                Storage::disk('public')->delete($parent->photo);
            }
            $data['photo'] = $request->file('photo')->store('parents', 'public');
        }

        $parent->update($data);

        return redirect()->route('admin.parents.index')->with('success', 'Parent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentModel $parent)
    {
        if ($parent->photo) {
            Storage::disk('public')->delete($parent->photo);
        }

        $parent->delete();

        return redirect()->route('admin.parents.index')->with('success', 'Parent deleted successfully.');
    }
}
