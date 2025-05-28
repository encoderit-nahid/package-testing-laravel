<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryCount extends Model
{

    protected $fillable = [
        'branch_id',
        'product_id',
        'unit_id',
        'quantity',
        'count_date',
        'deleted_at',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class);
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
