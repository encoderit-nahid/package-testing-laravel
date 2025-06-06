<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
        'code',
        'description',
        'image',
        'is_active',
        'parent_id',
        'created_by',
        'updated_by',
    ];


    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    //
}
