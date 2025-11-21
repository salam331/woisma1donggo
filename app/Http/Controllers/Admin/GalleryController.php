<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'is_active' => 'boolean',
            'additional_images.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*.description' => 'nullable|string',
        ]);

        $imagePath = $request->file('image')->store('galleries', 'public');

        $additionalImages = [];
        if ($request->has('additional_images')) {
            foreach ($request->additional_images as $key => $additional) {
                if (isset($additional['image']) && $additional['image']) {
                    $additionalImages[] = [
                        'image_path' => $additional['image']->store('galleries', 'public'),
                        'description' => $additional['description'] ?? '',
                    ];
                }
            }
        }

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'category' => $request->category,
            'event_date' => $request->event_date,
            'is_active' => $request->is_active ?? true,
            'additional_images' => $additionalImages,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'is_active' => 'boolean',
            'additional_images.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*.description' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'description', 'category', 'event_date', 'is_active']);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image_path);
            $data['image_path'] = $request->file('image')->store('galleries', 'public');
        }

        $additionalImages = [];
        $existingAdditionalImages = $gallery->additional_images ?? [];
        $existingPaths = array_column($existingAdditionalImages, 'image_path');

        if ($request->has('additional_images')) {
            foreach ($request->additional_images as $key => $additional) {
                if (isset($additional['image']) && $additional['image']) {
                    // New image uploaded, store it
                    $additionalImages[] = [
                        'image_path' => $additional['image']->store('galleries', 'public'),
                        'description' => $additional['description'] ?? '',
                    ];
                    // Remove from existing if it was there
                    if (isset($additional['existing_image_path'])) {
                        $keyToRemove = array_search($additional['existing_image_path'], $existingPaths);
                        if ($keyToRemove !== false) {
                            unset($existingPaths[$keyToRemove]);
                        }
                    }
                } elseif (isset($additional['existing_image_path'])) {
                    // Keep existing if no new image uploaded
                    $additionalImages[] = [
                        'image_path' => $additional['existing_image_path'],
                        'description' => $additional['description'] ?? '',
                    ];
                    // Remove from existing to avoid deletion
                    $keyToRemove = array_search($additional['existing_image_path'], $existingPaths);
                    if ($keyToRemove !== false) {
                        unset($existingPaths[$keyToRemove]);
                    }
                }
            }
        }

        // Delete images that are no longer in the list
        foreach ($existingPaths as $path) {
            Storage::disk('public')->delete($path);
        }
        $data['additional_images'] = $additionalImages;

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image_path);
        if ($gallery->additional_images) {
            foreach ($gallery->additional_images as $additional) {
                Storage::disk('public')->delete($additional['image_path']);
            }
        }
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery item deleted successfully.');
    }
}
