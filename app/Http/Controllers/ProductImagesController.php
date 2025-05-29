<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Resources\ProductImages\ProductImagesCollection;
use App\Http\Resources\ProductImages\ProductImagesResource;
use App\Models\ProductImages;
use App\Services\ProductImagesService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductImagesController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected ProductImagesService $productImagesService){}

    public static function middleware(): array
    {
        $model = 'product_images';

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
        $data = $this->productImagesService->getAll();

        return $this->success('ProductImages retrieved successfully', ProductImagesCollection::make($data));
    }

    public function store(ProductImagesRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $productImages = $this->productImagesService->store($request->validated());

            return $this->success('ProductImages created successfully', new ProductImagesResource($productImages));
        } catch (\Exception $e) {
            return $this->failure('ProductImages creation failed', 500, $e->getMessage());
        }
    }

    public function show(ProductImages $productImages): \Illuminate\Http\JsonResponse
    {
        return $this->success('ProductImages retrieved successfully', new ProductImagesResource($productImages));
    }

    public function update(ProductImagesRequest $request, ProductImages $productImages): \Illuminate\Http\JsonResponse
    {
        try {
            $this->productImagesService->update($productImages, $request->validated());

            return $this->success('ProductImages updated successfully', new ProductImagesResource($productImages));
        } catch (\Exception $e) {
            return $this->failure('ProductImages update failed', 500, $e->getMessage());
        }
    }

    public function destroy(ProductImages $productImages): \Illuminate\Http\JsonResponse
    {
        try {
             $this->productImagesService->delete($productImages);

            return $this->success('ProductImages deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('ProductImages deletion failed', 500, $e->getMessage());
        }
    }
}
