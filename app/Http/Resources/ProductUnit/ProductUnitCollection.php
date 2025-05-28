<?php

namespace App\Http\Resources\ProductUnit;

use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductUnitCollection extends ResourceCollection
{
    use MetaResponseTrait;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->transform(function ($productUnit) {
                return ProductUnitResource::make($productUnit);
            }),
            'meta' => $this->generateMeta(),
        ];
    }
}
