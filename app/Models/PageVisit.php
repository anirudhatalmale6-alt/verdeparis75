<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_url',
        'page_title',
        'ip_address',
        'user_agent',
        'referer',
        'country',
        'device_type',
    ];
}
