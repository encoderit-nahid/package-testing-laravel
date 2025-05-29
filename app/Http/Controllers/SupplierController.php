<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Http\Resources\Supplier\SupplierCollection;
use App\Http\Resources\Supplier\SupplierResource;
use App\Models\Supplier;
use App\Services\SupplierService;
use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SupplierController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected SupplierService $supplierService) {}

    public static function middleware(): array
    {
        $model = 'supplier';

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
        $data = $this->supplierService->getAll();

        return $this->success('Suppliers retrieved successfully', SupplierCollection::make($data));
    }

    public function store(SupplierRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $supplier = $this->supplierService->store($request->validated());

            return $this->success('Supplier created successfully', new SupplierResource($supplier));
        } catch (\Exception $e) {
            return $this->failure('Supplier creation failed', 500, $e->getMessage());
        }
    }

    public function show(Supplier $supplier): \Illuminate\Http\JsonResponse
    {
        return $this->success('Supplier retrieved successfully', new SupplierResource($supplier));
    }

    public function update(SupplierRequest $request, Supplier $supplier): \Illuminate\Http\JsonResponse
    {
        try {
            $this->supplierService->update($supplier, $request->validated());

            return $this->success('Supplier updated successfully', new SupplierResource($supplier));
        } catch (\Exception $e) {
            return $this->failure('Supplier update failed', 500, $e->getMessage());
        }
    }

    public function destroy(Supplier $supplier): \Illuminate\Http\JsonResponse
    {
        try {
            $this->supplierService->delete($supplier);

            return $this->success('Supplier deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('Supplier deletion failed', 500, $e->getMessage());
        }
    }
}
