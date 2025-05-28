<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected CategoryService $categoryService){}

    public static function middleware(): array
    {
        $model = 'category';

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
        $data = $this->categoryService->getAll();

        return $this->success('Categories retrieved successfully', CategoryCollection::make($data));
    }

    public function store(CategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $category = $this->categoryService->store($request->validated());

            return $this->success('Category created successfully', new CategoryResource($category));
        } catch (\Exception $e) {
            return $this->failure('Category creation failed', 500, $e->getMessage());
        }
    }

    public function show(Category $category): \Illuminate\Http\JsonResponse
    {
        return $this->success('Category retrieved successfully', new CategoryResource($category));
    }

    public function update(CategoryRequest $request, Category $category): \Illuminate\Http\JsonResponse
    {
        try {
            $this->categoryService->update($category, $request->validated());

            return $this->success('Category updated successfully', new CategoryResource($category));
        } catch (\Exception $e) {
            return $this->failure('Category update failed', 500, $e->getMessage());
        }
    }

    public function destroy(Category $category): \Illuminate\Http\JsonResponse
    {
        try {
             $this->categoryService->delete($category);

            return $this->success('Category deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('Category deletion failed', 500, $e->getMessage());
        }
    }
}
