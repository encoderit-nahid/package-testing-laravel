<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductUnitRequest;
use App\Http\Resources\ProductUnit\ProductUnitCollection;
use App\Http\Resources\ProductUnit\ProductUnitResource;
use App\Models\ProductUnit;
use App\Services\ProductUnitService;
use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductUnitController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected ProductUnitService $productUnitService) {}

    public static function middleware(): array
    {
        $model = 'product_unit';

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
        $data = $this->productUnitService->getAll();

        return $this->success('ProductUnits retrieved successfully', ProductUnitCollection::make($data));
    }

    public function store(ProductUnitRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $productUnit = $this->productUnitService->store($request->validated());

            return $this->success('ProductUnit created successfully', new ProductUnitResource($productUnit));
        } catch (\Exception $e) {
            return $this->failure('ProductUnit creation failed', 500, $e->getMessage());
        }
    }

    public function show(ProductUnit $productUnit): \Illuminate\Http\JsonResponse
    {
        return $this->success('ProductUnit retrieved successfully', new ProductUnitResource($productUnit));
    }

    public function update(ProductUnitRequest $request, ProductUnit $productUnit): \Illuminate\Http\JsonResponse
    {
        try {
            $this->productUnitService->update($productUnit, $request->validated());

            return $this->success('ProductUnit updated successfully', new ProductUnitResource($productUnit));
        } catch (\Exception $e) {
            return $this->failure('ProductUnit update failed', 500, $e->getMessage());
        }
    }

    public function destroy(ProductUnit $productUnit): \Illuminate\Http\JsonResponse
    {
        try {
            $this->productUnitService->delete($productUnit);

            return $this->success('ProductUnit deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('ProductUnit deletion failed', 500, $e->getMessage());
        }
    }
}
