<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\HomepageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomepageController extends Controller
{
    /**
     * The available homepage section keys.
     */
    protected array $sectionKeys = [
        'hero' => 'Hero / Bannière',
        'about' => 'À propos',
        'services_preview' => 'Aperçu des services',
        'projects_preview' => 'Aperçu des projets',
        'testimonials' => 'Témoignages',
        'cta' => 'Appel à l\'action',
        'stats' => 'Statistiques',
    ];

    /**
     * Display a listing of homepage sections.
     */
    public function index()
    {
        $sections = HomepageSection::ordered()->paginate(15);
        $sectionKeys = $this->sectionKeys;

        return view('admin.homepage.index', compact('sections', 'sectionKeys'));
    }

    /**
     * Show the form for editing a specific homepage section.
     */
    public function edit(string $sectionKey)
    {
        if (!array_key_exists($sectionKey, $this->sectionKeys)) {
            abort(404);
        }

        $section = HomepageSection::getSection($sectionKey) ?? new HomepageSection([
            'section_key' => $sectionKey,
        ]);

        $sectionLabel = $this->sectionKeys[$sectionKey];

        return view('admin.homepage.edit', compact('section', 'sectionKey', 'sectionLabel'));
    }

    /**
     * Update the specified homepage section.
     */
    public function update(Request $request, string $sectionKey)
    {
        if (!array_key_exists($sectionKey, $this->sectionKeys)) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:500',
            'extra_data' => 'nullable|array',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['section_key'] = $sectionKey;

        // Handle image upload
        if ($request->hasFile('image')) {
            $existingSection = HomepageSection::getSection($sectionKey);
            if ($existingSection && $existingSection->image && file_exists(storage_path('app/public/' . $existingSection->image))) {
                unlink(storage_path('app/public/' . $existingSection->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/homepage'), $filename);
            $validated['image'] = 'uploads/homepage/' . $filename;
        } else {
            unset($validated['image']);
        }

        $section = HomepageSection::updateOrCreate(
            ['section_key' => $sectionKey],
            $validated
        );

        AdminLog::log('updated', $section, [
            'section' => $sectionKey,
        ]);

        return redirect()->route('admin.homepage.index')
            ->with('success', "Section \"{$this->sectionKeys[$sectionKey]}\" mise à jour avec succès.");
    }
}
