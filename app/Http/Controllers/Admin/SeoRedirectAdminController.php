<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoRedirect;
use App\Models\AdminLog;
use Illuminate\Http\Request;

class SeoRedirectAdminController extends Controller
{
    public function index()
    {
        $redirects = SeoRedirect::latest()->paginate(50);
        return view('admin.seo-pro.redirects', compact('redirects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'source_path' => 'required|string|max:255',
            'target_url' => 'required|string|max:255',
            'status_code' => 'required|in:301,302',
            'is_active' => 'nullable',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $redirect = SeoRedirect::updateOrCreate(['source_path' => $data['source_path']], $data);
        AdminLog::log('created', $redirect, ['source' => $data['source_path']]);

        return back()->with('success', 'Redirection enregistree.');
    }

    public function destroy(SeoRedirect $redirect)
    {
        AdminLog::log('deleted', $redirect, ['source' => $redirect->source_path]);
        $redirect->delete();
        return back()->with('success', 'Redirection supprimee.');
    }
}
