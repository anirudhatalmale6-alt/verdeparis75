<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'content',
        'image',
        'button_text',
        'button_url',
        'extra_data',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'extra_data' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope to only active sections.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get a homepage section by its key.
     */
    public static function getSection(string $key): ?self
    {
        return static::where('section_key', $key)->first();
    }
}
