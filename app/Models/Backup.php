<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'type',
        'size',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }
}
