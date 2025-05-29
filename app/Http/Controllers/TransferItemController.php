<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferItemRequest;
use App\Http\Resources\TransferItem\TransferItemCollection;
use App\Http\Resources\TransferItem\TransferItemResource;
use App\Models\TransferItem;
use App\Services\TransferItemService;
use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TransferItemController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected TransferItemService $transferItemService) {}

    public static function middleware(): array
    {
        $model = 'transfer_item';

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
        $data = $this->transferItemService->getAll();

        return $this->success('TransferItems retrieved successfully', TransferItemCollection::make($data));
    }

    public function store(TransferItemRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $transferItem = $this->transferItemService->store($request->validated());

            return $this->success('TransferItem created successfully', new TransferItemResource($transferItem));
        } catch (\Exception $e) {
            return $this->failure('TransferItem creation failed', 500, $e->getMessage());
        }
    }

    public function show(TransferItem $transferItem): \Illuminate\Http\JsonResponse
    {
        return $this->success('TransferItem retrieved successfully', new TransferItemResource($transferItem));
    }

    public function update(TransferItemRequest $request, TransferItem $transferItem): \Illuminate\Http\JsonResponse
    {
        try {
            $this->transferItemService->update($transferItem, $request->validated());

            return $this->success('TransferItem updated successfully', new TransferItemResource($transferItem));
        } catch (\Exception $e) {
            return $this->failure('TransferItem update failed', 500, $e->getMessage());
        }
    }

    public function destroy(TransferItem $transferItem): \Illuminate\Http\JsonResponse
    {
        try {
            $this->transferItemService->delete($transferItem);

            return $this->success('TransferItem deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('TransferItem deletion failed', 500, $e->getMessage());
        }
    }
}
