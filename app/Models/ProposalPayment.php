<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalPayment extends Model
{
    protected $fillable = [
        'proposal_id',
        'date',
        'amount',
        'payment_type',
        'transaction_id',
        'created_by',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
