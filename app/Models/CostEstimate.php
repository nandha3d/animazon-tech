<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostEstimate extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'project_type_id',
        'project_name',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'base_cost',
        'total_cost',
        'tax_percentage',
        'tax_amount',
        'grand_total',
        'currency_code',
        'timeline_weeks',
        'team_size',
        'status',
        'notes',
        'document_path',
        'sent_at',
        'accepted_at',
        'rejected_at'
    ];

    protected $casts = [
        'base_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'sent_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Customer::class, 'client_id');
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function answers()
    {
        return $this->hasMany(CostEstimateAnswer::class);
    }
}
