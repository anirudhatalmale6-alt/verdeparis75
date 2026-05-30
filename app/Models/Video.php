<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video_url',
        'video_type',
        'thumbnail',
        'category',
        'views',
        'likes',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'views' => 'integer',
            'likes' => 'integer',
        ];
    }

    /**
     * Get the embeddable URL for the video.
     */
    public function getEmbedUrlAttribute(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        return match ($this->video_type) {
            'youtube' => $this->getYoutubeEmbedUrl(),
            'vimeo' => $this->getVimeoEmbedUrl(),
            default => $this->video_url,
        };
    }

    /**
     * Extract and return YouTube embed URL.
     */
    protected function getYoutubeEmbedUrl(): ?string
    {
        $videoId = null;

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->video_url, $matches)) {
            $videoId = $matches[1];
        }

        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }

    /**
     * Extract and return Vimeo embed URL.
     */
    protected function getVimeoEmbedUrl(): ?string
    {
        $videoId = null;

        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $this->video_url, $matches)) {
            $videoId = $matches[1];
        }

        return $videoId ? "https://player.vimeo.com/video/{$videoId}" : null;
    }

    /**
     * Scope to only active videos.
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

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
