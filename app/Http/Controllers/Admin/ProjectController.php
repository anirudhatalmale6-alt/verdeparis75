<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index()
    {
        $projects = Project::withCount('images')->ordered()->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/projects'), $filename);
            $validated['cover_image'] = 'uploads/projects/' . $filename;
        }

        $project = Project::create($validated);

        AdminLog::log('created', $project, ['title' => $project->title]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet créé avec succès.');
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        $project->load('images');

        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($project->cover_image && file_exists(storage_path('app/public/' . $project->cover_image))) {
                unlink(storage_path('app/public/' . $project->cover_image));
            }

            $file = $request->file('cover_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/projects'), $filename);
            $validated['cover_image'] = 'uploads/projects/' . $filename;
        }

        $project->update($validated);

        AdminLog::log('updated', $project, ['title' => $project->title]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet mis à jour avec succès.');
    }

    /**
     * Remove the specified project.
     */
    public function destroy(Project $project)
    {
        // Delete cover image
        if ($project->cover_image && file_exists(storage_path('app/public/' . $project->cover_image))) {
            unlink(storage_path('app/public/' . $project->cover_image));
        }

        // Delete all project images
        foreach ($project->images as $image) {
            if ($image->image && file_exists(storage_path('app/public/' . $image->image))) {
                unlink(storage_path('app/public/' . $image->image));
            }
        }

        AdminLog::log('deleted', $project, ['title' => $project->title]);

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet supprimé avec succès.');
    }

    /**
     * Add an image to a project.
     */
    public function addImage(Request $request, Project $project)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'caption' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $file = $request->file('image');
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/public/uploads/projects'), $filename);

        $projectImage = $project->images()->create([
            'image' => 'uploads/projects/' . $filename,
            'caption' => $request->input('caption'),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        AdminLog::log('created', $projectImage, [
            'project' => $project->title,
            'image' => $filename,
        ]);

        return redirect()->back()
            ->with('success', 'Image ajoutée au projet avec succès.');
    }

    /**
     * Remove an image from a project.
     */
    public function removeImage(ProjectImage $projectImage)
    {
        // Delete the file
        if ($projectImage->image && file_exists(storage_path('app/public/' . $projectImage->image))) {
            unlink(storage_path('app/public/' . $projectImage->image));
        }

        AdminLog::log('deleted', $projectImage, [
            'project_id' => $projectImage->project_id,
            'image' => $projectImage->image,
        ]);

        $projectImage->delete();

        return redirect()->back()
            ->with('success', 'Image supprimée avec succès.');
    }
}
