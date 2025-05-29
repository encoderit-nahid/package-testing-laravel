<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{

    protected $fillable = [
        'product_unit_id',
        'image',
        'is_default',
    ];


    public function productUnit()
    {
        return $this->belongsTo(Product::class);
    }

    //
}
