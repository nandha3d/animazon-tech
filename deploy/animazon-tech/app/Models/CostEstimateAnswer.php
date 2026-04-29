<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostEstimateAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost_estimate_id',
        'question_id',
        'answer_id',
        'answer_value', // for text/input questions
        'cost_contribution'
    ];

    protected $casts = [
        'cost_contribution' => 'decimal:2'
    ];

    public function estimate()
    {
        return $this->belongsTo(CostEstimate::class);
    }

    public function question()
    {
        return $this->belongsTo(CostCalculatorQuestion::class);
    }

    public function answer()
    {
        return $this->belongsTo(CostCalculatorAnswer::class);
    }
}
