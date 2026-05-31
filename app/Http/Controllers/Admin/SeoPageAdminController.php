<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeoPageAdminController extends Controller
{
    public function index()
    {
        $pages = SeoPage::orderBy('sort_order')->paginate(30);
        return view('admin.seo-pro.pages', compact('pages'));
    }

    public function create()
    {
        return view('admin.seo-pro.page-form', ['page' => new SeoPage()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $page = SeoPage::create($data);
        AdminLog::log('created', $page, ['title' => $page->title]);
        return redirect()->route('admin.seo-pro.pages.index')->with('success', 'Page SEO creee.');
    }

    public function edit(SeoPage $page)
    {
        return view('admin.seo-pro.page-form', compact('page'));
    }

    public function update(Request $request, SeoPage $page)
    {
        $page->update($this->validated($request));
        AdminLog::log('updated', $page, ['title' => $page->title]);
        return back()->with('success', 'Page SEO mise a jour.');
    }

    public function destroy(SeoPage $page)
    {
        AdminLog::log('deleted', $page, ['title' => $page->title]);
        $page->delete();
        return back()->with('success', 'Page supprimee.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'locale' => 'nullable|string|max:8',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'h1' => 'nullable|string|max:255',
            'sections' => 'nullable|string',
            'keywords' => 'nullable|string',
            'canonical_url' => 'nullable|string|max:255',
            'is_indexable' => 'nullable',
            'is_active' => 'nullable',
            'sort_order' => 'nullable|integer',
        ]);

        $data['slug'] = Str::slug($data['slug']);
        $data['sections'] = !empty($data['sections']) ? json_decode($data['sections'], true) : [];
        $data['keywords'] = !empty($data['keywords']) ? array_map('trim', explode(',', $data['keywords'])) : [];
        $data['is_indexable'] = $request->boolean('is_indexable');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
