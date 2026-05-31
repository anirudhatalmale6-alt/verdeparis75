<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use App\Models\SeoRedirect;

class SeoProDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pages' => SeoPage::count(),
            'active_pages' => SeoPage::where('is_active', true)->count(),
            'missing_meta' => SeoPage::whereNull('meta_description')->orWhere('meta_description', '')->count(),
            'redirects' => SeoRedirect::where('is_active', true)->count(),
        ];

        return view('admin.seo-pro.dashboard', compact('stats'));
    }
}
