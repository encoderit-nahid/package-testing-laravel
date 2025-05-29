<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\IntermediateProductRequest;
use App\Http\Resources\IntermediateProduct\IntermediateProductCollection;
use App\Http\Resources\IntermediateProduct\IntermediateProductResource;
use App\Models\IntermediateProduct;
use App\Services\IntermediateProductService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class IntermediateProductController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected IntermediateProductService $intermediateProductService){}

    public static function middleware(): array
    {
        $model = 'intermediate_product';

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
        $data = $this->intermediateProductService->getAll();

        return $this->success('IntermediateProducts retrieved successfully', IntermediateProductCollection::make($data));
    }

    public function store(IntermediateProductRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $intermediateProduct = $this->intermediateProductService->store($request->validated());

            return $this->success('IntermediateProduct created successfully', new IntermediateProductResource($intermediateProduct));
        } catch (\Exception $e) {
            return $this->failure('IntermediateProduct creation failed', 500, $e->getMessage());
        }
    }

    public function show(IntermediateProduct $intermediateProduct): \Illuminate\Http\JsonResponse
    {
        return $this->success('IntermediateProduct retrieved successfully', new IntermediateProductResource($intermediateProduct));
    }

    public function update(IntermediateProductRequest $request, IntermediateProduct $intermediateProduct): \Illuminate\Http\JsonResponse
    {
        try {
            $this->intermediateProductService->update($intermediateProduct, $request->validated());

            return $this->success('IntermediateProduct updated successfully', new IntermediateProductResource($intermediateProduct));
        } catch (\Exception $e) {
            return $this->failure('IntermediateProduct update failed', 500, $e->getMessage());
        }
    }

    public function destroy(IntermediateProduct $intermediateProduct): \Illuminate\Http\JsonResponse
    {
        try {
             $this->intermediateProductService->delete($intermediateProduct);

            return $this->success('IntermediateProduct deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('IntermediateProduct deletion failed', 500, $e->getMessage());
        }
    }
}
