<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index()
    {
        $services = Service::ordered()->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/services'), $filename);
            $validated['image'] = 'uploads/services/' . $filename;
        }

        $service = Service::create($validated);

        AdminLog::log('created', $service, ['title' => $service->title]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service créé avec succès.');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified service.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($service->image && file_exists(storage_path('app/public/' . $service->image))) {
                unlink(storage_path('app/public/' . $service->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/services'), $filename);
            $validated['image'] = 'uploads/services/' . $filename;
        }

        $service->update($validated);

        AdminLog::log('updated', $service, ['title' => $service->title]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service mis à jour avec succès.');
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Service $service)
    {
        // Delete associated image
        if ($service->image && file_exists(storage_path('app/public/' . $service->image))) {
            unlink(storage_path('app/public/' . $service->image));
        }

        AdminLog::log('deleted', $service, ['title' => $service->title]);

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service supprimé avec succès.');
    }
}
