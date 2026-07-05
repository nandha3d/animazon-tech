<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'session_id',
        'direction',
        'body',
        'visitor_name',
        'wa_message_id',
        'delivered',
    ];

    protected $casts = [
        'delivered' => 'boolean',
    ];
}
