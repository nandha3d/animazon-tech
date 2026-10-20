<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateStoreId extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'channel_name',
        'is_default',
        'notes',
    ];

    /**
     * Get default store ID
     */
    public static function getDefaultStoreId()
    {
        $default = self::where('is_default', true)->first();
        return $default ? $default->store_id : 'ramyadevikola-21';
    }
}
