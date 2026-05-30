<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LegalPageController extends Controller
{
    /**
     * Display a listing of legal pages.
     */
    public function index()
    {
        $pages = LegalPage::latest()->paginate(15);

        return view('admin.legal-pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new legal page.
     */
    public function create()
    {
        return view('admin.legal-pages.create');
    }

    /**
     * Store a newly created legal page.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');

        $legalPage = LegalPage::create($validated);

        AdminLog::log('created', $legalPage, ['title' => $legalPage->title]);

        return redirect()->route('admin.legal-pages.index')
            ->with('success', 'Page légale créée avec succès.');
    }

    /**
     * Show the form for editing the specified legal page.
     */
    public function edit(LegalPage $legalPage)
    {
        $page = $legalPage;
        return view('admin.legal-pages.edit', compact('page'));
    }

    /**
     * Update the specified legal page.
     */
    public function update(Request $request, LegalPage $legalPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');

        $legalPage->update($validated);

        AdminLog::log('updated', $legalPage, ['title' => $legalPage->title]);

        return redirect()->route('admin.legal-pages.index')
            ->with('success', 'Page légale mise à jour avec succès.');
    }

    /**
     * Remove the specified legal page.
     */
    public function destroy(LegalPage $legalPage)
    {
        AdminLog::log('deleted', $legalPage, ['title' => $legalPage->title]);

        $legalPage->delete();

        return redirect()->route('admin.legal-pages.index')
            ->with('success', 'Page légale supprimée avec succès.');
    }
}
