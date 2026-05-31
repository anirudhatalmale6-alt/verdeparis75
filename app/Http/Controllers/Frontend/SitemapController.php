<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $pages = SeoPage::where('is_active', true)
            ->where('is_indexable', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        $xml = view('frontend.seo.sitemap', compact('pages'))->render();

        return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots()
    {
        $domain = config('seo-pro.domain');
        $lines = ['User-agent: *'];

        foreach (config('seo-pro.robots.disallow', []) as $path) {
            $lines[] = "Disallow: {$path}";
        }

        $lines[] = 'Allow: /';
        $lines[] = "Sitemap: {$domain}/sitemap.xml";

        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain']);
    }
}
