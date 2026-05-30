<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            ['key' => 'visitor_widget_enabled', 'value' => '1', 'type' => 'checkbox', 'group' => 'visitor_widget', 'label' => 'Activer le widget visiteurs'],
            ['key' => 'visitor_widget_text', 'value' => 'PERSONNES SUR LE SITE', 'type' => 'text', 'group' => 'visitor_widget', 'label' => 'Texte du widget'],
            ['key' => 'visitor_widget_color', 'value' => '#0E7A32', 'type' => 'text', 'group' => 'visitor_widget', 'label' => 'Couleur principale (hex)'],
            ['key' => 'visitor_widget_position', 'value' => 'after_hero', 'type' => 'text', 'group' => 'visitor_widget', 'label' => 'Position (after_hero, before_footer, floating)'],
        ];

        foreach ($settings as $s) {
            DB::table('settings')->updateOrInsert(
                ['key' => $s['key']],
                array_merge($s, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'visitor_widget_enabled',
            'visitor_widget_text',
            'visitor_widget_color',
            'visitor_widget_position',
        ])->delete();
    }
};
