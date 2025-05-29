<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAll()
    {
        return Category::paginate(perPage());
    }

    public function store($request)
    {
        return Category::create($request);
    }

    public function update($request, Category $category)
    {
        $category->update($request);

        return $category;
    }

    public function delete(Category $category)
    {
        $category->delete();

        return $category;
    }
}
