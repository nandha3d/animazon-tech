<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCalculatorQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_type_id',
        'question',
        'description',
        'type', // 'single_select', 'multi_select', 'input'
        'order',
        'required',
        'category', // e.g., 'scope', 'timeline', 'features', 'design'
        'active'
    ];

    protected $casts = [
        'required' => 'boolean',
        'active' => 'boolean'
    ];

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function answers()
    {
        return $this->hasMany(CostCalculatorAnswer::class, 'question_id');
    }
}
