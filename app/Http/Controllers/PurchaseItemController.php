<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseItemRequest;
use App\Http\Resources\PurchaseItem\PurchaseItemCollection;
use App\Http\Resources\PurchaseItem\PurchaseItemResource;
use App\Models\PurchaseItem;
use App\Services\PurchaseItemService;
use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PurchaseItemController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected PurchaseItemService $purchaseItemService) {}

    public static function middleware(): array
    {
        $model = 'purchase_item';

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
        $data = $this->purchaseItemService->getAll();

        return $this->success('PurchaseItems retrieved successfully', PurchaseItemCollection::make($data));
    }

    public function store(PurchaseItemRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $purchaseItem = $this->purchaseItemService->store($request->validated());

            return $this->success('PurchaseItem created successfully', new PurchaseItemResource($purchaseItem));
        } catch (\Exception $e) {
            return $this->failure('PurchaseItem creation failed', 500, $e->getMessage());
        }
    }

    public function show(PurchaseItem $purchaseItem): \Illuminate\Http\JsonResponse
    {
        return $this->success('PurchaseItem retrieved successfully', new PurchaseItemResource($purchaseItem));
    }

    public function update(PurchaseItemRequest $request, PurchaseItem $purchaseItem): \Illuminate\Http\JsonResponse
    {
        try {
            $this->purchaseItemService->update($purchaseItem, $request->validated());

            return $this->success('PurchaseItem updated successfully', new PurchaseItemResource($purchaseItem));
        } catch (\Exception $e) {
            return $this->failure('PurchaseItem update failed', 500, $e->getMessage());
        }
    }

    public function destroy(PurchaseItem $purchaseItem): \Illuminate\Http\JsonResponse
    {
        try {
            $this->purchaseItemService->delete($purchaseItem);

            return $this->success('PurchaseItem deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('PurchaseItem deletion failed', 500, $e->getMessage());
        }
    }
}
