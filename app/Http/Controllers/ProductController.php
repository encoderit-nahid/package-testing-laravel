<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected ProductService $productService){}

    public static function middleware(): array
    {
        $model = 'product';

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
        $data = $this->productService->getAll();

        return $this->success('Products retrieved successfully', ProductCollection::make($data));
    }

    public function store(ProductRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $product = $this->productService->store($request->validated());

            return $this->success('Product created successfully', new ProductResource($product));
        } catch (\Exception $e) {
            return $this->failure('Product creation failed', 500, $e->getMessage());
        }
    }

    public function show(Product $product): \Illuminate\Http\JsonResponse
    {
        return $this->success('Product retrieved successfully', new ProductResource($product));
    }

    public function update(ProductRequest $request, Product $product): \Illuminate\Http\JsonResponse
    {
        try {
            $this->productService->update($product, $request->validated());

            return $this->success('Product updated successfully', new ProductResource($product));
        } catch (\Exception $e) {
            return $this->failure('Product update failed', 500, $e->getMessage());
        }
    }

    public function destroy(Product $product): \Illuminate\Http\JsonResponse
    {
        try {
             $this->productService->delete($product);

            return $this->success('Product deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('Product deletion failed', 500, $e->getMessage());
        }
    }
}
