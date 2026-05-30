<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of videos.
     */
    public function index()
    {
        $videos = Video::ordered()->paginate(15);

        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new video.
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    /**
     * Store a newly created video.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url|max:500',
            'video_type' => 'required|string|in:youtube,vimeo,other',
            'thumbnail' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $video = Video::create($validated);

        AdminLog::log('created', $video, ['title' => $video->title]);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo ajoutée avec succès.');
    }

    /**
     * Show the form for editing the specified video.
     */
    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Update the specified video.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url|max:500',
            'video_type' => 'required|string|in:youtube,vimeo,other',
            'thumbnail' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $video->update($validated);

        AdminLog::log('updated', $video, ['title' => $video->title]);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo mise à jour avec succès.');
    }

    /**
     * Remove the specified video.
     */
    public function destroy(Video $video)
    {
        AdminLog::log('deleted', $video, ['title' => $video->title]);

        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo supprimée avec succès.');
    }
}
