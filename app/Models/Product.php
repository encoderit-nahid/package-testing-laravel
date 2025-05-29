<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'image',
        'is_active',
        'is_default',
        'created_by',
        'updated_by',
    ];


    //
}
