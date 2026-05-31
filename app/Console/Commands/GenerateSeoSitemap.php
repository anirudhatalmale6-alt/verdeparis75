<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SeoPage;

class GenerateSeoSitemap extends Command
{
    protected $signature = 'seo:generate-sitemap';
    protected $description = 'Generate sitemap.xml for SEO Pro';

    public function handle(): int
    {
        $pages = SeoPage::where('is_active', true)->where('is_indexable', true)->get();
        $xml = view('frontend.seo.sitemap', compact('pages'))->render();
        file_put_contents(public_path('sitemap.xml'), $xml);
        $this->info('Sitemap generated: ' . public_path('sitemap.xml'));
        return self::SUCCESS;
    }
}
