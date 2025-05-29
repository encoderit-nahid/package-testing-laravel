<?php

namespace App\Services;

use App\Models\Purchase;

class PurchaseService
{
    public function getAll()
    {
        return Purchase::paginate(perPage());
    }

    public function store($request)
    {
        return Purchase::create($request);
    }

    public function update($request, Purchase $purchase)
    {
        $purchase->update($request);

        return $purchase;
    }

    public function delete(Purchase $purchase)
    {
        $purchase->delete();

        return $purchase;
    }
}
