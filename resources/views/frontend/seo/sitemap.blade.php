<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ config('seo-pro.domain') }}/</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>
    <url><loc>{{ config('seo-pro.domain') }}/services</loc><changefreq>monthly</changefreq><priority>0.9</priority></url>
    <url><loc>{{ config('seo-pro.domain') }}/realisations</loc><changefreq>monthly</changefreq><priority>0.9</priority></url>
    <url><loc>{{ config('seo-pro.domain') }}/galerie</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ config('seo-pro.domain') }}/videos</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ config('seo-pro.domain') }}/contact</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ config('seo-pro.domain') }}/avant-apres</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>
@foreach($pages as $page)
    <url>
        <loc>{{ config('seo-pro.domain') }}/{{ $page->slug }}</loc>
        <lastmod>{{ optional($page->updated_at)->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
@endforeach
</urlset>
