<?php

namespace App\Services;

use App\Models\Recipe;

class RecipeService
{
    public function getAll()
    {
        return Recipe::paginate(perPage());
    }

    public function store($request)
    {
        return Recipe::create($request);
    }

    public function update($request, Recipe $recipe)
    {
        $recipe->update($request);

        return $recipe;
    }

    public function delete(Recipe $recipe)
    {
        $recipe->delete();

        return $recipe;
    }
}
