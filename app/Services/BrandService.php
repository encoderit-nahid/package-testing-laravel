<?php

namespace App\Services;

use App\Models\Brand;

class BrandService
{
    public function getAll()
    {
        return Brand::paginate(perPage());
    }

    public function store($request)
    {
        return Brand::create($request);
    }

    public function update($request, Brand $brand)
    {
        $brand->update($request);
        return $brand;
    }

    public function delete(Brand $brand)
    {
        $brand->delete();
        return $brand;
    }
}
