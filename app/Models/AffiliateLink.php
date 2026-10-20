<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'asin',
        'target_url',
        'affiliate_tag',
        'title',
        'clicks',
        'android_clicks',
        'ios_clicks',
        'desktop_clicks',
    ];

    /**
     * Helper to get full target Amazon URL with tag
     */
    public function getFinalAmazonUrlAttribute()
    {
        $tag = $this->affiliate_tag ?: 'ramyadevikola-21';
        
        if ($this->asin) {
            return "https://www.amazon.in/dp/{$this->asin}?tag={$tag}";
        }

        if ($this->target_url) {
            $url = $this->target_url;
            if (strpos($url, 'tag=') === false) {
                $separator = (strpos($url, '?') !== false) ? '&' : '?';
                $url .= "{$separator}tag={$tag}";
            }
            return $url;
        }

        // Fallback to Amazon IN home
        return "https://www.amazon.in/?tag={$tag}";
    }
}
