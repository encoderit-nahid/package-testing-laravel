<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Http\Resources\Unit\UnitCollection;
use App\Http\Resources\Unit\UnitResource;
use App\Models\Unit;
use App\Services\UnitService;
use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UnitController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected UnitService $unitService) {}

    public static function middleware(): array
    {
        $model = 'unit';

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
        $data = $this->unitService->getAll();

        return $this->success('Units retrieved successfully', UnitCollection::make($data));
    }

    public function store(UnitRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $unit = $this->unitService->store($request->validated());

            return $this->success('Unit created successfully', new UnitResource($unit));
        } catch (\Exception $e) {
            return $this->failure('Unit creation failed', 500, $e->getMessage());
        }
    }

    public function show(Unit $unit): \Illuminate\Http\JsonResponse
    {
        return $this->success('Unit retrieved successfully', new UnitResource($unit));
    }

    public function update(UnitRequest $request, Unit $unit): \Illuminate\Http\JsonResponse
    {
        try {
            $this->unitService->update($unit, $request->validated());

            return $this->success('Unit updated successfully', new UnitResource($unit));
        } catch (\Exception $e) {
            return $this->failure('Unit update failed', 500, $e->getMessage());
        }
    }

    public function destroy(Unit $unit): \Illuminate\Http\JsonResponse
    {
        try {
            $this->unitService->delete($unit);

            return $this->success('Unit deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('Unit deletion failed', 500, $e->getMessage());
        }
    }
}
