<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    /**
     * Settings groups with their respective keys and labels.
     */
    protected array $groups = [
        'general' => [
            'label' => 'Général',
            'fields' => [
                'site_name' => ['label' => 'Nom du site', 'type' => 'text'],
                'site_tagline' => ['label' => 'Slogan', 'type' => 'text'],
                'logo' => ['label' => 'Logo', 'type' => 'image'],
                'favicon' => ['label' => 'Favicon', 'type' => 'image'],
            ],
        ],
        'contact' => [
            'label' => 'Contact',
            'fields' => [
                'address' => ['label' => 'Adresse', 'type' => 'text'],
                'phone' => ['label' => 'Téléphone', 'type' => 'text'],
                'email' => ['label' => 'Email', 'type' => 'text'],
                'map_embed' => ['label' => 'Code embed carte', 'type' => 'textarea'],
            ],
        ],
        'social' => [
            'label' => 'Réseaux sociaux',
            'fields' => [
                'facebook' => ['label' => 'Facebook', 'type' => 'text'],
                'instagram' => ['label' => 'Instagram', 'type' => 'text'],
                'linkedin' => ['label' => 'LinkedIn', 'type' => 'text'],
                'twitter' => ['label' => 'Twitter / X', 'type' => 'text'],
            ],
        ],
        'footer' => [
            'label' => 'Pied de page',
            'fields' => [
                'footer_text' => ['label' => 'Texte du pied de page', 'type' => 'textarea'],
                'footer_copyright' => ['label' => 'Copyright', 'type' => 'text'],
            ],
        ],
    ];

    /**
     * Display all settings grouped by category.
     */
    public function index()
    {
        $settings = Setting::all();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Bulk save all settings.
     */
    public function update(Request $request)
    {
        $updatedKeys = [];

        foreach ($this->groups as $groupKey => $group) {
            foreach ($group['fields'] as $fieldKey => $fieldConfig) {
                if ($fieldConfig['type'] === 'image') {
                    // Handle image upload
                    if ($request->hasFile("settings.{$fieldKey}")) {
                        $request->validate([
                            "settings.{$fieldKey}" => 'image|mimes:jpeg,png,jpg,gif,webp,svg,ico|max:3072',
                        ]);

                        // Delete old image if exists
                        $existingSetting = Setting::where('key', $fieldKey)->first();
                        if ($existingSetting && $existingSetting->value && file_exists(storage_path('app/public/' . $existingSetting->value))) {
                            unlink(storage_path('app/public/' . $existingSetting->value));
                        }

                        $file = $request->file("settings.{$fieldKey}");
                        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                        $file->move(storage_path('app/public/uploads/settings'), $filename);

                        Setting::updateOrCreate(
                            ['key' => $fieldKey],
                            [
                                'value' => 'uploads/settings/' . $filename,
                                'type' => 'image',
                                'group' => $groupKey,
                                'label' => $fieldConfig['label'],
                            ]
                        );

                        $updatedKeys[] = $fieldKey;
                    }
                } else {
                    // Handle text/textarea fields
                    $value = $request->input("settings.{$fieldKey}");

                    Setting::updateOrCreate(
                        ['key' => $fieldKey],
                        [
                            'value' => $value,
                            'type' => $fieldConfig['type'],
                            'group' => $groupKey,
                            'label' => $fieldConfig['label'],
                        ]
                    );

                    $updatedKeys[] = $fieldKey;
                }
            }
        }

        AdminLog::log('updated', null, [
            'action' => 'settings_bulk_update',
            'keys' => $updatedKeys,
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres mis à jour avec succès.');
    }
}
