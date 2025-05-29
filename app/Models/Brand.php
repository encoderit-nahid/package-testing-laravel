<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $fillable = [
        'name',
        'description',
        'logo',
        'is_active',
        'is_default',
        'created_by',
        'updated_by',
    ];


    //
}
