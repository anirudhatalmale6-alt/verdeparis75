<?php

namespace App\Services;

use App\Models\SeoPage;

class SeoProService
{
    public function metaForPage(?SeoPage $page = null): array
    {
        $site = config('seo-pro.site_name', 'VERDE PARIS 75');

        if (!$page) {
            return [
                'title' => $site . ' | Terrassement, VRD, Assainissement en Ile-de-France',
                'description' => 'VERDE PARIS 75 realise vos travaux de terrassement, VRD, assainissement, reseaux divers et maconnerie en Ile-de-France.',
                'canonical' => url()->current(),
                'robots' => 'index,follow',
            ];
        }

        return [
            'title' => $page->seo_title ?: $page->title . ' | ' . $site,
            'description' => $page->meta_description,
            'canonical' => $page->canonical_url ?: $page->url(),
            'robots' => $page->is_indexable ? 'index,follow' : 'noindex,nofollow',
        ];
    }

    public function localBusinessSchema(): array
    {
        $company = config('seo-pro.company');

        return [
            '@context' => 'https://schema.org',
            '@type' => ['LocalBusiness', 'ConstructionCompany'],
            'name' => $company['name'],
            'url' => config('seo-pro.domain'),
            'description' => $company['description'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $company['address'],
                'addressCountry' => 'FR',
            ],
            'areaServed' => $company['area_served'],
            'sameAs' => [],
        ];
    }
}
