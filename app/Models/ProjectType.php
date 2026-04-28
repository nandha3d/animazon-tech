<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectType extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
                
                // Ensure uniqueness
                $originalSlug = $model->slug;
                $count = 1;
                while (static::where('slug', $model->slug)->where('id', '!=', $model->id)->exists()) {
                    $model->slug = "{$originalSlug}-" . $count++;
                }
            }
        });
    }

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'icon',
        'image_path',
        'base_cost',
        'active'
    ];

    protected $casts = [
        'base_cost' => 'decimal:2',
        'active' => 'boolean'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ─── Relationships ────────────────────────────────────

    public function parent()
    {
        return $this->belongsTo(ProjectType::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProjectType::class, 'parent_id');
    }

    public function questions()
    {
        return $this->hasMany(CostCalculatorQuestion::class);
    }

    public function estimates()
    {
        return $this->hasMany(CostEstimate::class);
    }

    // ─── Helpers ──────────────────────────────────────────

    public function isCategory(): bool
    {
        return is_null($this->parent_id);
    }

    public function isSubService(): bool
    {
        return !is_null($this->parent_id);
    }

    /**
     * Get active children (sub-services) ordered by name
     */
    public function activeChildren()
    {
        return $this->children()->where('active', true)->orderBy('name');
    }
}
