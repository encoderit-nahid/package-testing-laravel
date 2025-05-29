<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitConversion extends Model
{

    protected $fillable = [
        'from_unit_id',
        'to_unit_id',
        'multiplier',
    ];


    public function fromUnit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function toUnit()
    {
        return $this->belongsTo(Unit::class);
    }

    //
}
