<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitConversionRequest;
use App\Http\Resources\UnitConversion\UnitConversionCollection;
use App\Http\Resources\UnitConversion\UnitConversionResource;
use App\Models\UnitConversion;
use App\Services\UnitConversionService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UnitConversionController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected UnitConversionService $unitConversionService){}

    public static function middleware(): array
    {
        $model = 'unit_conversion';

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
        $data = $this->unitConversionService->getAll();

        return $this->success('UnitConversions retrieved successfully', UnitConversionCollection::make($data));
    }

    public function store(UnitConversionRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $unitConversion = $this->unitConversionService->store($request->validated());

            return $this->success('UnitConversion created successfully', new UnitConversionResource($unitConversion));
        } catch (\Exception $e) {
            return $this->failure('UnitConversion creation failed', 500, $e->getMessage());
        }
    }

    public function show(UnitConversion $unitConversion): \Illuminate\Http\JsonResponse
    {
        return $this->success('UnitConversion retrieved successfully', new UnitConversionResource($unitConversion));
    }

    public function update(UnitConversionRequest $request, UnitConversion $unitConversion): \Illuminate\Http\JsonResponse
    {
        try {
            $this->unitConversionService->update($unitConversion, $request->validated());

            return $this->success('UnitConversion updated successfully', new UnitConversionResource($unitConversion));
        } catch (\Exception $e) {
            return $this->failure('UnitConversion update failed', 500, $e->getMessage());
        }
    }

    public function destroy(UnitConversion $unitConversion): \Illuminate\Http\JsonResponse
    {
        try {
             $this->unitConversionService->delete($unitConversion);

            return $this->success('UnitConversion deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('UnitConversion deletion failed', 500, $e->getMessage());
        }
    }
}
