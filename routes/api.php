<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('units', \App\Http\Controllers\UnitController::class);

Route::apiResource('unit_conversions', \App\Http\Controllers\UnitConversionController::class);

Route::apiResource('branches', \App\Http\Controllers\BranchController::class);

Route::apiResource('categories', \App\Http\Controllers\CategoryController::class);

Route::apiResource('brands', \App\Http\Controllers\BrandController::class);

Route::apiResource('suppliers', \App\Http\Controllers\SupplierController::class);

Route::apiResource('products', \App\Http\Controllers\ProductController::class);

Route::apiResource('product_units', \App\Http\Controllers\ProductUnitController::class);

Route::apiResource('recipes', \App\Http\Controllers\RecipeController::class);

Route::apiResource('intermediate_products', \App\Http\Controllers\IntermediateProductController::class);

Route::apiResource('purchases', \App\Http\Controllers\PurchaseController::class);

Route::apiResource('purchase_items', \App\Http\Controllers\PurchaseItemController::class);

Route::apiResource('transfers', \App\Http\Controllers\TransferController::class);

Route::apiResource('transfer_items', \App\Http\Controllers\TransferItemController::class);

Route::apiResource('inventory_counts', \App\Http\Controllers\InventoryCountController::class);
