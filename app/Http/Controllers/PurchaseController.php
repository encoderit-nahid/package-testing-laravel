<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\Purchase\PurchaseCollection;
use App\Http\Resources\Purchase\PurchaseResource;
use App\Models\Purchase;
use App\Services\PurchaseService;
use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PurchaseController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected PurchaseService $purchaseService) {}

    public static function middleware(): array
    {
        $model = 'purchase';

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
        $data = $this->purchaseService->getAll();

        return $this->success('Purchases retrieved successfully', PurchaseCollection::make($data));
    }

    public function store(PurchaseRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $purchase = $this->purchaseService->store($request->validated());

            return $this->success('Purchase created successfully', new PurchaseResource($purchase));
        } catch (\Exception $e) {
            return $this->failure('Purchase creation failed', 500, $e->getMessage());
        }
    }

    public function show(Purchase $purchase): \Illuminate\Http\JsonResponse
    {
        return $this->success('Purchase retrieved successfully', new PurchaseResource($purchase));
    }

    public function update(PurchaseRequest $request, Purchase $purchase): \Illuminate\Http\JsonResponse
    {
        try {
            $this->purchaseService->update($purchase, $request->validated());

            return $this->success('Purchase updated successfully', new PurchaseResource($purchase));
        } catch (\Exception $e) {
            return $this->failure('Purchase update failed', 500, $e->getMessage());
        }
    }

    public function destroy(Purchase $purchase): \Illuminate\Http\JsonResponse
    {
        try {
            $this->purchaseService->delete($purchase);

            return $this->success('Purchase deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('Purchase deletion failed', 500, $e->getMessage());
        }
    }
}
