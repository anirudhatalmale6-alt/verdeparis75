<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_identifier',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'custom_head',
    ];

    /**
     * Get the SEO setting for a specific page identifier.
     */
    public static function forPage(string $identifier): ?self
    {
        return static::where('page_identifier', $identifier)->first();
    }
}
