<?php

namespace App\Http\Resources\TransferItem;

use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransferItemCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($transferItem) {
                return TransferItemResource::make($transferItem);
            }),
            'meta' => $this->generateMeta(),
        ];
    }
}
