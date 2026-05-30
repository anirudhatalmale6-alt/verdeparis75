<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope to only active legal pages.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
