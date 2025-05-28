<?php

namespace App\Services;

use App\Models\Transfer;

class TransferService
{
    public function getAll()
    {
        return Transfer::paginate(perPage());
    }

    public function store($request)
    {
        return Transfer::create($request);
    }

    public function update($request, Transfer $transfer)
    {
        $transfer->update($request);
        return $transfer;
    }

    public function delete(Transfer $transfer)
    {
        $transfer->delete();
        return $transfer;
    }
}
