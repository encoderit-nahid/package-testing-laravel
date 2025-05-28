<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Http\Resources\Branch\BranchCollection;
use App\Http\Resources\Branch\BranchResource;
use App\Models\Branch;
use App\Services\BranchService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BranchController extends Controller implements HasMiddleware
{
    use ApiResponseTrait;

    public function __construct(protected BranchService $branchService){}

    public static function middleware(): array
    {
        $model = 'branch';

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
        $data = $this->branchService->getAll();

        return $this->success('Branches retrieved successfully', BranchCollection::make($data));
    }

    public function store(BranchRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $branch = $this->branchService->store($request->validated());

            return $this->success('Branch created successfully', new BranchResource($branch));
        } catch (\Exception $e) {
            return $this->failure('Branch creation failed', 500, $e->getMessage());
        }
    }

    public function show(Branch $branch): \Illuminate\Http\JsonResponse
    {
        return $this->success('Branch retrieved successfully', new BranchResource($branch));
    }

    public function update(BranchRequest $request, Branch $branch): \Illuminate\Http\JsonResponse
    {
        try {
            $this->branchService->update($branch, $request->validated());

            return $this->success('Branch updated successfully', new BranchResource($branch));
        } catch (\Exception $e) {
            return $this->failure('Branch update failed', 500, $e->getMessage());
        }
    }

    public function destroy(Branch $branch): \Illuminate\Http\JsonResponse
    {
        try {
             $this->branchService->delete($branch);

            return $this->success('Branch deleted successfully');
        } catch (\Exception $e) {
            return $this->failure('Branch deletion failed', 500, $e->getMessage());
        }
    }
}
