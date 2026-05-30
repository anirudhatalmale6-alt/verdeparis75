<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\BeforeAfter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeforeAfterController extends Controller
{
    /**
     * Display a listing of before/after entries.
     */
    public function index()
    {
        $items = BeforeAfter::ordered()->paginate(15);

        return view('admin.before-after.index', compact('items'));
    }

    /**
     * Show the form for creating a new before/after entry.
     */
    public function create()
    {
        return view('admin.before-after.create');
    }

    /**
     * Store a newly created before/after entry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'before_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'after_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // Handle before image upload
        if ($request->hasFile('before_image')) {
            $file = $request->file('before_image');
            $filename = time() . '_before_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/before-afters'), $filename);
            $validated['before_image'] = 'uploads/before-afters/' . $filename;
        }

        // Handle after image upload
        if ($request->hasFile('after_image')) {
            $file = $request->file('after_image');
            $filename = time() . '_after_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/before-afters'), $filename);
            $validated['after_image'] = 'uploads/before-afters/' . $filename;
        }

        $beforeAfter = BeforeAfter::create($validated);

        AdminLog::log('created', $beforeAfter, ['title' => $beforeAfter->title]);

        return redirect()->route('admin.before-after.index')
            ->with('success', 'Avant/Après créé avec succès.');
    }

    /**
     * Show the form for editing the specified before/after entry.
     */
    public function edit(BeforeAfter $beforeAfter)
    {
        $item = $beforeAfter;
        return view('admin.before-after.edit', compact('item'));
    }

    /**
     * Update the specified before/after entry.
     */
    public function update(Request $request, BeforeAfter $beforeAfter)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'before_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'after_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // Handle before image upload
        if ($request->hasFile('before_image')) {
            if ($beforeAfter->before_image && file_exists(storage_path('app/public/' . $beforeAfter->before_image))) {
                unlink(storage_path('app/public/' . $beforeAfter->before_image));
            }

            $file = $request->file('before_image');
            $filename = time() . '_before_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/before-afters'), $filename);
            $validated['before_image'] = 'uploads/before-afters/' . $filename;
        }

        // Handle after image upload
        if ($request->hasFile('after_image')) {
            if ($beforeAfter->after_image && file_exists(storage_path('app/public/' . $beforeAfter->after_image))) {
                unlink(storage_path('app/public/' . $beforeAfter->after_image));
            }

            $file = $request->file('after_image');
            $filename = time() . '_after_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/before-afters'), $filename);
            $validated['after_image'] = 'uploads/before-afters/' . $filename;
        }

        $beforeAfter->update($validated);

        AdminLog::log('updated', $beforeAfter, ['title' => $beforeAfter->title]);

        return redirect()->route('admin.before-after.index')
            ->with('success', 'Avant/Après mis à jour avec succès.');
    }

    /**
     * Remove the specified before/after entry.
     */
    public function destroy(BeforeAfter $beforeAfter)
    {
        // Delete both images
        if ($beforeAfter->before_image && file_exists(storage_path('app/public/' . $beforeAfter->before_image))) {
            unlink(storage_path('app/public/' . $beforeAfter->before_image));
        }

        if ($beforeAfter->after_image && file_exists(storage_path('app/public/' . $beforeAfter->after_image))) {
            unlink(storage_path('app/public/' . $beforeAfter->after_image));
        }

        AdminLog::log('deleted', $beforeAfter, ['title' => $beforeAfter->title]);

        $beforeAfter->delete();

        return redirect()->route('admin.before-after.index')
            ->with('success', 'Avant/Après supprimé avec succès.');
    }
}
