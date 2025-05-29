<?php

namespace App\Services;

use App\Models\Unit;

class UnitService
{
    public function getAll()
    {
        return Unit::paginate(perPage());
    }

    public function store($request)
    {
        return Unit::create($request);
    }

    public function update($request, Unit $unit)
    {
        $unit->update($request);
        return $unit;
    }

    public function delete(Unit $unit)
    {
        $unit->delete();
        return $unit;
    }
}
