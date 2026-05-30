<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
    ];

    /**
     * Scope to filter settings by group.
     */
    public function scopeForGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Get a setting value by key, with an optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }
}
