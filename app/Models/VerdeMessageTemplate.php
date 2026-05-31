<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerdeMessageTemplate extends Model
{
    protected $fillable = ['title', 'subject', 'body', 'is_default'];

    protected $casts = ['is_default' => 'boolean'];
}
