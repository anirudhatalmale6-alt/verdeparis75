<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    /**
     * Display a listing of photos.
     */
    public function index()
    {
        $photos = Photo::ordered()->paginate(15);

        return view('admin.photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new photo.
     */
    public function create()
    {
        return view('admin.photos.create');
    }

    /**
     * Store a newly created photo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/photos'), $filename);
            $validated['image'] = 'uploads/photos/' . $filename;
        }

        $photo = Photo::create($validated);

        AdminLog::log('created', $photo, ['title' => $photo->title]);

        return redirect()->route('admin.photos.index')
            ->with('success', 'Photo ajoutée avec succès.');
    }

    /**
     * Store multiple photos at once (bulk upload).
     */
    public function storeBulk(Request $request)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $isActive = $request->boolean('is_active');
        $category = $request->input('category');
        $count = 0;

        foreach ($request->file('images') as $file) {
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/photos'), $filename);

            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $photo = Photo::create([
                'title' => $originalName,
                'image' => 'uploads/photos/' . $filename,
                'category' => $category,
                'is_active' => $isActive,
                'sort_order' => 0,
            ]);

            $count++;
        }

        AdminLog::log('bulk_created', null, [
            'model' => 'Photo',
            'count' => $count,
        ]);

        return redirect()->route('admin.photos.index')
            ->with('success', "{$count} photo(s) ajoutée(s) avec succès.");
    }

    /**
     * Show the form for editing the specified photo.
     */
    public function edit(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    /**
     * Update the specified photo.
     */
    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($photo->image && file_exists(storage_path('app/public/' . $photo->image))) {
                unlink(storage_path('app/public/' . $photo->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/photos'), $filename);
            $validated['image'] = 'uploads/photos/' . $filename;
        }

        $photo->update($validated);

        AdminLog::log('updated', $photo, ['title' => $photo->title]);

        return redirect()->route('admin.photos.index')
            ->with('success', 'Photo mise à jour avec succès.');
    }

    /**
     * Remove the specified photo.
     */
    public function destroy(Photo $photo)
    {
        // Delete the image file
        if ($photo->image && file_exists(storage_path('app/public/' . $photo->image))) {
            unlink(storage_path('app/public/' . $photo->image));
        }

        // Delete thumbnail if exists
        if ($photo->thumbnail && file_exists(storage_path('app/public/' . $photo->thumbnail))) {
            unlink(storage_path('app/public/' . $photo->thumbnail));
        }

        AdminLog::log('deleted', $photo, ['title' => $photo->title]);

        $photo->delete();

        return redirect()->route('admin.photos.index')
            ->with('success', 'Photo supprimée avec succès.');
    }
}
