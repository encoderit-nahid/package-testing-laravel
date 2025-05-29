<?php

namespace App\Services;

use App\Models\Branch;

class BranchService
{
    public function getAll()
    {
        return Branch::paginate(perPage());
    }

    public function store($request)
    {
        return Branch::create($request);
    }

    public function update($request, Branch $branch)
    {
        $branch->update($request);

        return $branch;
    }

    public function delete(Branch $branch)
    {
        $branch->delete();

        return $branch;
    }
}
