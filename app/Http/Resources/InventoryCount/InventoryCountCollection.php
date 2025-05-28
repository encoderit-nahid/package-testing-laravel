<?php

namespace App\Http\Resources\InventoryCount;

use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InventoryCountCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($inventoryCount) {
                return InventoryCountResource::make($inventoryCount);
            }),
            'meta' => $this->generateMeta(),
        ];
    }
}
