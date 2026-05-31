<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    protected $fillable = [
        'locale', 'title', 'slug', 'seo_title', 'meta_description',
        'h1', 'sections', 'keywords', 'canonical_url',
        'is_indexable', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'sections' => 'array',
        'keywords' => 'array',
        'is_indexable' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function url(): string
    {
        return url('/' . $this->slug);
    }
}
