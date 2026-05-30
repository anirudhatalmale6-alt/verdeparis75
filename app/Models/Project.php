<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'short_description',
        'client_name',
        'location',
        'project_date',
        'cover_image',
        'category',
        'slug',
        'is_featured',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'project_date' => 'date',
        ];
    }

    /**
     * Get the images for the project.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    /**
     * Scope to only active projects.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to only featured projects.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
