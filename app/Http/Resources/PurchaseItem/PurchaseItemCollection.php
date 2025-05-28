<?php

namespace App\Http\Resources\PurchaseItem;

use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseItemCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($purchaseItem) {
                return PurchaseItemResource::make($purchaseItem);
            }),
            'meta' => $this->generateMeta(),
        ];
    }
}
