<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryCountRequest;
use App\Http\Resources\InventoryCount\InventoryCountCollection;
use App\Http\Resources\InventoryCount\InventoryCountResource;
use App\Models\InventoryCount;
use App\Services\InventoryCountService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class InventoryCountController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected InventoryCountService $inventoryCountService){}

    public static function middleware(): array
    {
        $model = 'inventory_count';

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
        $data = $this->inventoryCountService->getAll();

        return $this->success('InventoryCounts retrieved successfully', InventoryCountCollection::make($data));
    }

    public function store(InventoryCountRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $inventoryCount = $this->inventoryCountService->store($request->validated());

            return $this->success('InventoryCount created successfully', new InventoryCountResource($inventoryCount));
        } catch (\Exception $e) {
            return $this->failure('InventoryCount creation failed', 500, $e->getMessage());
        }
    }

    public function show(InventoryCount $inventoryCount): \Illuminate\Http\JsonResponse
    {
        return $this->success('InventoryCount retrieved successfully', new InventoryCountResource($inventoryCount));
    }

    public function update(InventoryCountRequest $request, InventoryCount $inventoryCount): \Illuminate\Http\JsonResponse
    {
        try {
            $this->inventoryCountService->update($inventoryCount, $request->validated());

            return $this->success('InventoryCount updated successfully', new InventoryCountResource($inventoryCount));
        } catch (\Exception $e) {
            return $this->failure('InventoryCount update failed', 500, $e->getMessage());
        }
    }

    public function destroy(InventoryCount $inventoryCount): \Illuminate\Http\JsonResponse
    {
        try {
             $this->inventoryCountService->delete($inventoryCount);

            return $this->success('InventoryCount deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('InventoryCount deletion failed', 500, $e->getMessage());
        }
    }
}
