<?php

namespace App\Services;

use App\Models\UnitConversion;

class UnitConversionService
{
    public function getAll()
    {
        return UnitConversion::paginate(perPage());
    }

    public function store($request)
    {
        return UnitConversion::create($request);
    }

    public function update($request, UnitConversion $unitConversion)
    {
        $unitConversion->update($request);

        return $unitConversion;
    }

    public function delete(UnitConversion $unitConversion)
    {
        $unitConversion->delete();

        return $unitConversion;
    }
}
