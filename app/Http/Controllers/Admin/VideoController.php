<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'video_url' => 'nullable|url|max:500',
            'video_type' => 'required|string|in:youtube,vimeo,mp4,other',
            'video_file' => 'nullable|file|mimes:mp4,mov,webm,avi,quicktime|max:512000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('video_file')) {
            $vFile = $request->file('video_file');
            $vFilename = time() . '_' . Str::random(10) . '.' . $vFile->getClientOriginalExtension();
            $vFile->move(storage_path('app/public/uploads/videos'), $vFilename);
            $validated['video_url'] = asset('storage/uploads/videos/' . $vFilename);
            if (!isset($validated['video_type']) || $validated['video_type'] === 'other') {
                $validated['video_type'] = 'mp4';
            }
        }
        unset($validated['video_file']);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/videos'), $filename);
            $validated['thumbnail'] = 'uploads/videos/' . $filename;
        } else {
            unset($validated['thumbnail']);
        }

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
            'video_url' => 'nullable|url|max:500',
            'video_type' => 'required|string|in:youtube,vimeo,mp4,other',
            'video_file' => 'nullable|file|mimes:mp4,mov,webm,avi,quicktime|max:512000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('video_file')) {
            $vFile = $request->file('video_file');
            $vFilename = time() . '_' . Str::random(10) . '.' . $vFile->getClientOriginalExtension();
            $vFile->move(storage_path('app/public/uploads/videos'), $vFilename);
            $validated['video_url'] = asset('storage/uploads/videos/' . $vFilename);
            if (!isset($validated['video_type']) || $validated['video_type'] === 'other') {
                $validated['video_type'] = 'mp4';
            }
        }
        unset($validated['video_file']);

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail && file_exists(storage_path('app/public/' . $video->thumbnail))) {
                unlink(storage_path('app/public/' . $video->thumbnail));
            }
            $file = $request->file('thumbnail');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/videos'), $filename);
            $validated['thumbnail'] = 'uploads/videos/' . $filename;
        } else {
            unset($validated['thumbnail']);
        }

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
