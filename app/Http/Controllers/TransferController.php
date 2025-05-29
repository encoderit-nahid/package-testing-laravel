<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Http\Resources\Transfer\TransferCollection;
use App\Http\Resources\Transfer\TransferResource;
use App\Models\Transfer;
use App\Services\TransferService;
use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TransferController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected TransferService $transferService) {}

    public static function middleware(): array
    {
        $model = 'transfer';

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
        $data = $this->transferService->getAll();

        return $this->success('Transfers retrieved successfully', TransferCollection::make($data));
    }

    public function store(TransferRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $transfer = $this->transferService->store($request->validated());

            return $this->success('Transfer created successfully', new TransferResource($transfer));
        } catch (\Exception $e) {
            return $this->failure('Transfer creation failed', 500, $e->getMessage());
        }
    }

    public function show(Transfer $transfer): \Illuminate\Http\JsonResponse
    {
        return $this->success('Transfer retrieved successfully', new TransferResource($transfer));
    }

    public function update(TransferRequest $request, Transfer $transfer): \Illuminate\Http\JsonResponse
    {
        try {
            $this->transferService->update($transfer, $request->validated());

            return $this->success('Transfer updated successfully', new TransferResource($transfer));
        } catch (\Exception $e) {
            return $this->failure('Transfer update failed', 500, $e->getMessage());
        }
    }

    public function destroy(Transfer $transfer): \Illuminate\Http\JsonResponse
    {
        try {
            $this->transferService->delete($transfer);

            return $this->success('Transfer deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('Transfer deletion failed', 500, $e->getMessage());
        }
    }
}
