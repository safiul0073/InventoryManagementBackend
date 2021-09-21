<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SaleController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth');
Route::post('refresh', [UserController::class, 'refresh']);
Route::get('me', [UserController::class, 'me'])->middleware('auth');
Route::post('register', [UserController::class, 'register']);

Route::apiResources([
    'category' => CategoryController::class,
    'product' => ProductController::class,
    'unit' => UnitController::class,
    'product-sell' => SaleController::class,
]);

Route::get('sell-items', [SaleController::class, 'sellItems']);
Route::get('total-sell', [SaleController::class, 'totalOrder']);
Route::get('total-items', [SaleController::class, 'totalItems']);
Route::get('total-user', [SaleController::class, 'totalUser']);


