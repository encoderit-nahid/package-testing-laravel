<?php

namespace App\Services;

use App\Models\ProductUnit;

class ProductUnitService
{
    public function getAll()
    {
        return ProductUnit::paginate(perPage());
    }

    public function store($request)
    {
        return ProductUnit::create($request);
    }

    public function update($request, ProductUnit $productUnit)
    {
        $productUnit->update($request);
        return $productUnit;
    }

    public function delete(ProductUnit $productUnit)
    {
        $productUnit->delete();
        return $productUnit;
    }
}
