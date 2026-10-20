<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateClickLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_link_id',
        'code',
        'asin',
        'store_id',
        'device_type',
        'ip_address',
        'user_agent',
        'referer',
    ];
}
