<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Http\Resources\Recipe\RecipeCollection;
use App\Http\Resources\Recipe\RecipeResource;
use App\Models\Recipe;
use App\Services\RecipeService;
use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RecipeController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected RecipeService $recipeService) {}

    public static function middleware(): array
    {
        $model = 'recipe';

        return [
            'auth',
            new Middleware(["permission:view_$model"], only: ['index']),
            new Middleware(["permission:show_$model"], only: ['show']),
            new Middleware(["permission:create_$model"], only: ['store']),
            new Middleware(["permission:update_$model"], only: ['update']),
            new Middleware(["permission:delete_$model"], only: ['destroy']),
        ];
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = $this->recipeService->getAll();

        return $this->success('Recipes retrieved successfully', RecipeCollection::make($data));
    }

    public function store(RecipeRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $recipe = $this->recipeService->store($request->validated());

            return $this->success('Recipe created successfully', new RecipeResource($recipe));
        } catch (\Exception $e) {
            return $this->failure('Recipe creation failed', 500, $e->getMessage());
        }
    }

    public function show(Recipe $recipe): \Illuminate\Http\JsonResponse
    {
        return $this->success('Recipe retrieved successfully', new RecipeResource($recipe));
    }

    public function update(RecipeRequest $request, Recipe $recipe): \Illuminate\Http\JsonResponse
    {
        try {
            $this->recipeService->update($recipe, $request->validated());

            return $this->success('Recipe updated successfully', new RecipeResource($recipe));
        } catch (\Exception $e) {
            return $this->failure('Recipe update failed', 500, $e->getMessage());
        }
    }

    public function destroy(Recipe $recipe): \Illuminate\Http\JsonResponse
    {
        try {
            $this->recipeService->delete($recipe);

            return $this->success('Recipe deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('Recipe deletion failed', 500, $e->getMessage());
        }
    }
}
