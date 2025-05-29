<?php

namespace App\Services;

use App\Models\PurchaseItem;

class PurchaseItemService
{
    public function getAll()
    {
        return PurchaseItem::paginate(perPage());
    }

    public function store($request)
    {
        return PurchaseItem::create($request);
    }

    public function update($request, PurchaseItem $purchaseItem)
    {
        $purchaseItem->update($request);

        return $purchaseItem;
    }

    public function delete(PurchaseItem $purchaseItem)
    {
        $purchaseItem->delete();

        return $purchaseItem;
    }
}
