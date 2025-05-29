<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Http\Resources\Brand\BrandCollection;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;
use App\Services\BrandService;
use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BrandController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected BrandService $brandService) {}

    public static function middleware(): array
    {
        $model = 'brand';

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
        $data = $this->brandService->getAll();

        return $this->success('Brands retrieved successfully', BrandCollection::make($data));
    }

    public function store(BrandRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $brand = $this->brandService->store($request->validated());

            return $this->success('Brand created successfully', new BrandResource($brand));
        } catch (\Exception $e) {
            return $this->failure('Brand creation failed', 500, $e->getMessage());
        }
    }

    public function show(Brand $brand): \Illuminate\Http\JsonResponse
    {
        return $this->success('Brand retrieved successfully', new BrandResource($brand));
    }

    public function update(BrandRequest $request, Brand $brand): \Illuminate\Http\JsonResponse
    {
        try {
            $this->brandService->update($brand, $request->validated());

            return $this->success('Brand updated successfully', new BrandResource($brand));
        } catch (\Exception $e) {
            return $this->failure('Brand update failed', 500, $e->getMessage());
        }
    }

    public function destroy(Brand $brand): \Illuminate\Http\JsonResponse
    {
        try {
            $this->brandService->delete($brand);

            return $this->success('Brand deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('Brand deletion failed', 500, $e->getMessage());
        }
    }
}
