<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    protected $fillable = [
        'recipe_id',
        'product_id',
        'quantity',
        'unit_id',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    //
}
