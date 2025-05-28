<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $fillable = [
        'name',
        'is_commissary',
        'code',
        'address',
        'phone',
        'email',
        'is_active',
        'is_default',
        'logo',
        'manager_id',
        'created_by',
        'updated_by',
    ];


    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    //
}
