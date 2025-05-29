<?php

namespace App\Services;

use App\Models\ProductImages;

class ProductImagesService
{
    public function getAll()
    {
        return ProductImages::paginate(perPage());
    }

    public function store($request)
    {
        return ProductImages::create($request);
    }

    public function update($request, ProductImages $productImages)
    {
        $productImages->update($request);

        return $productImages;
    }

    public function delete(ProductImages $productImages)
    {
        $productImages->delete();

        return $productImages;
    }
}
