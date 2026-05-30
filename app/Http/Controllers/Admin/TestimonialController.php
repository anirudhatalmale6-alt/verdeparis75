<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created testimonial.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_location' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/testimonials'), $filename);
            $validated['image'] = 'uploads/testimonials/' . $filename;
        }

        $testimonial = Testimonial::create($validated);

        AdminLog::log('created', $testimonial, ['name' => $testimonial->client_name]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Témoignage créé avec succès.');
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_location' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($testimonial->image && file_exists(storage_path('app/public/' . $testimonial->image))) {
                unlink(storage_path('app/public/' . $testimonial->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/testimonials'), $filename);
            $validated['image'] = 'uploads/testimonials/' . $filename;
        }

        $testimonial->update($validated);

        AdminLog::log('updated', $testimonial, ['name' => $testimonial->client_name]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Témoignage mis à jour avec succès.');
    }

    /**
     * Remove the specified testimonial.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Delete image file
        if ($testimonial->image && file_exists(storage_path('app/public/' . $testimonial->image))) {
            unlink(storage_path('app/public/' . $testimonial->image));
        }

        AdminLog::log('deleted', $testimonial, ['name' => $testimonial->name]);

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Témoignage supprimé avec succès.');
    }
}
