<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use App\Services\SeoProService;

class SeoPageController extends Controller
{
    public function show(string $slug, SeoProService $seo)
    {
        $page = SeoPage::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $meta = $seo->metaForPage($page);
        $schema = $seo->localBusinessSchema();

        return view('frontend.seo.page', compact('page', 'meta', 'schema'));
    }
}
