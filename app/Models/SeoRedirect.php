<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoRedirect extends Model
{
    protected $fillable = ['source_path', 'target_url', 'status_code', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
