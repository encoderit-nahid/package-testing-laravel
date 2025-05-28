<?php

namespace App\Services;

use App\Models\Supplier;

class SupplierService
{
    public function getAll()
    {
        return Supplier::paginate(perPage());
    }

    public function store($request)
    {
        return Supplier::create($request);
    }

    public function update($request, Supplier $supplier)
    {
        $supplier->update($request);
        return $supplier;
    }

    public function delete(Supplier $supplier)
    {
        $supplier->delete();
        return $supplier;
    }
}
