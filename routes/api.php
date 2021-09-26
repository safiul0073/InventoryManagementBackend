<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SaleController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth');
Route::post('refresh', [UserController::class, 'refresh']);
Route::get('me', [UserController::class, 'me'])->middleware('auth');
Route::post('register', [UserController::class, 'register']);

Route::middleware(['auth', ])->group(function () {
    Route::apiResources([
        'category' => CategoryController::class,
        'product' => ProductController::class,
        'unit' => UnitController::class,
        'product-sell' => SaleController::class,
    ]);
    
    Route::get('total-sell', [SaleController::class, 'totalOrder']);
    Route::get('total-items', [SaleController::class, 'totalItems']);
    Route::get('total-user', [SaleController::class, 'totalUser']);
});



