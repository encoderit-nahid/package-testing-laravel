<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{

    protected $fillable = [
        'from_branch_id',
        'to_branch_id',
        'transfer_date',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_at',
    ];


    public function fromBranch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class);
    }

    //
}
