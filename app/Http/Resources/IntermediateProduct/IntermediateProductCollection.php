<?php

namespace App\Http\Resources\IntermediateProduct;

use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IntermediateProductCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($intermediateProduct) {
                return IntermediateProductResource::make($intermediateProduct);
            }),
            'meta' => $this->generateMeta(),
        ];
    }
}
