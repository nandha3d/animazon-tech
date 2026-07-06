<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalComment extends Model
{
    protected $table = 'proposal_comments';

    protected $fillable = [
        'proposal_id',
        'user_id',
        'client_name',
        'client_email',
        'category',
        'comment',
    ];
}
