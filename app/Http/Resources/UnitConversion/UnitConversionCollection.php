<?php

namespace App\Http\Resources\UnitConversion;

use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UnitConversionCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($unitConversion) {
                return UnitConversionResource::make($unitConversion);
            }),
            'meta' => $this->generateMeta(),
        ];
    }
}
