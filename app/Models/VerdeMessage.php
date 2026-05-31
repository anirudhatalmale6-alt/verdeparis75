<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerdeMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'service', 'message', 'source_page',
        'ip_address', 'user_agent', 'is_read', 'is_archived', 'is_spam', 'read_at',
        'replied_at', 'forwarded_to',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_archived' => 'boolean',
        'is_spam' => 'boolean',
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
        'forwarded_to' => 'array',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeInbox($query)
    {
        return $query->where('is_archived', false)->where('is_spam', false);
    }
}
