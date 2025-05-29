<?php

namespace App\Services;

use App\Models\InventoryCount;

class InventoryCountService
{
    public function getAll()
    {
        return InventoryCount::paginate(perPage());
    }

    public function store($request)
    {
        return InventoryCount::create($request);
    }

    public function update($request, InventoryCount $inventoryCount)
    {
        $inventoryCount->update($request);

        return $inventoryCount;
    }

    public function delete(InventoryCount $inventoryCount)
    {
        $inventoryCount->delete();

        return $inventoryCount;
    }
}
