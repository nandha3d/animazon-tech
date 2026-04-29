<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCalculatorAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'answer_text',
        'cost_multiplier', // 0.5 to 3.0
        'additional_cost', // fixed amount to add
        'explanation',
        'insight', // contextual real-world cost/info for the user
        'order',
        'active',
        'is_included',
        'is_enterprise'
    ];

    protected $casts = [
        'cost_multiplier' => 'decimal:2',
        'additional_cost' => 'decimal:2',
        'active' => 'boolean',
        'is_included' => 'boolean',
        'is_enterprise' => 'boolean'
    ];

    public function question()
    {
        return $this->belongsTo(CostCalculatorQuestion::class, 'question_id');
    }

    public function estimateAnswers()
    {
        return $this->hasMany(CostEstimateAnswer::class, 'answer_id');
    }
}
