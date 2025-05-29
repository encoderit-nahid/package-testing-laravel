<?php

namespace App\Services;

use App\Models\TransferItem;

class TransferItemService
{
    public function getAll()
    {
        return TransferItem::paginate(perPage());
    }

    public function store($request)
    {
        return TransferItem::create($request);
    }

    public function update($request, TransferItem $transferItem)
    {
        $transferItem->update($request);
        return $transferItem;
    }

    public function delete(TransferItem $transferItem)
    {
        $transferItem->delete();
        return $transferItem;
    }
}
