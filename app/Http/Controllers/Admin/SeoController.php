<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    /**
     * The available page identifiers for SEO settings.
     */
    protected array $pages = [
        'home' => 'Accueil',
        'services' => 'Services',
        'projects' => 'Projets',
        'gallery' => 'Galerie',
        'videos' => 'Vidéos',
        'contact' => 'Contact',
        'partners' => 'Partenaires',
    ];

    /**
     * Display a listing of all SEO page settings.
     */
    public function index()
    {
        $seoSettings = SeoSetting::all()->keyBy('page_identifier');
        $pages = $this->pages;

        return view('admin.seo.index', compact('seoSettings', 'pages'));
    }

    /**
     * Show the form for editing SEO settings for a specific page.
     */
    public function edit(string $pageIdentifier)
    {
        if (!array_key_exists($pageIdentifier, $this->pages)) {
            abort(404);
        }

        $seoSetting = SeoSetting::forPage($pageIdentifier) ?? new SeoSetting([
            'page_identifier' => $pageIdentifier,
        ]);

        $pageName = $this->pages[$pageIdentifier];

        return view('admin.seo.edit', compact('seoSetting', 'pageIdentifier', 'pageName'));
    }

    /**
     * Update SEO settings for a specific page.
     */
    public function update(Request $request, string $pageIdentifier)
    {
        if (!array_key_exists($pageIdentifier, $this->pages)) {
            abort(404);
        }

        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'custom_head' => 'nullable|string|max:2000',
        ]);

        $validated['page_identifier'] = $pageIdentifier;

        $seoSetting = SeoSetting::updateOrCreate(
            ['page_identifier' => $pageIdentifier],
            $validated
        );

        AdminLog::log('updated', $seoSetting, [
            'page' => $pageIdentifier,
        ]);

        return redirect()->route('admin.seo.index')
            ->with('success', "SEO de la page \"{$this->pages[$pageIdentifier]}\" mis à jour avec succès.");
    }
}
