<?php

namespace App\Services;

use App\Models\IntermediateProduct;

class IntermediateProductService
{
    public function getAll()
    {
        return IntermediateProduct::paginate(perPage());
    }

    public function store($request)
    {
        return IntermediateProduct::create($request);
    }

    public function update($request, IntermediateProduct $intermediateProduct)
    {
        $intermediateProduct->update($request);

        return $intermediateProduct;
    }

    public function delete(IntermediateProduct $intermediateProduct)
    {
        $intermediateProduct->delete();

        return $intermediateProduct;
    }
}
