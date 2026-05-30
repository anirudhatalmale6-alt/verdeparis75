<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    /**
     * Display a listing of partners.
     */
    public function index()
    {
        $partners = Partner::ordered()->paginate(15);

        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new partner.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a newly created partner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:3072',
            'website' => 'nullable|url|max:500',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/partners'), $filename);
            $validated['logo'] = 'uploads/partners/' . $filename;
        }

        $partner = Partner::create($validated);

        AdminLog::log('created', $partner, ['name' => $partner->name]);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partenaire créé avec succès.');
    }

    /**
     * Show the form for editing the specified partner.
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified partner.
     */
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:3072',
            'website' => 'nullable|url|max:500',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($partner->logo && file_exists(storage_path('app/public/' . $partner->logo))) {
                unlink(storage_path('app/public/' . $partner->logo));
            }

            $file = $request->file('logo');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/uploads/partners'), $filename);
            $validated['logo'] = 'uploads/partners/' . $filename;
        }

        $partner->update($validated);

        AdminLog::log('updated', $partner, ['name' => $partner->name]);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partenaire mis à jour avec succès.');
    }

    /**
     * Remove the specified partner.
     */
    public function destroy(Partner $partner)
    {
        // Delete logo file
        if ($partner->logo && file_exists(storage_path('app/public/' . $partner->logo))) {
            unlink(storage_path('app/public/' . $partner->logo));
        }

        AdminLog::log('deleted', $partner, ['name' => $partner->name]);

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partenaire supprimé avec succès.');
    }
}
