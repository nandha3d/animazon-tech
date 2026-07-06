<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalAttachment extends Model
{
    protected $table = 'proposal_attachments';

    protected $fillable = [
        'proposal_id',
        'user_id',
        'client_name',
        'category',
        'file_name',
        'file_path',
        'file_size',
    ];
}
