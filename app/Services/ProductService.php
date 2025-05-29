<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAll()
    {
        return Product::paginate(perPage());
    }

    public function store($request)
    {
        return Product::create($request);
    }

    public function update($request, Product $product)
    {
        $product->update($request);

        return $product;
    }

    public function delete(Product $product)
    {
        $product->delete();

        return $product;
    }
}
