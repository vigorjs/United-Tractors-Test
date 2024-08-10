<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryProductController;
use App\Http\Controllers\api\ProductController;
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

Route::prefix('v1')->group(function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Routes yang butuh token
Route::middleware('auth:sanctum')->prefix('v1')->group(function() {
    Route::get('logout', [AuthController::class, 'logout']);

    // Routes untuk CategoryProductController
    Route::get('category-products', [CategoryProductController::class, 'index']);
    Route::post('category-products', [CategoryProductController::class, 'store']);
    Route::get('category-products/{id}', [CategoryProductController::class, 'show']);
    Route::put('category-products/{id}', [CategoryProductController::class, 'update']);
    Route::delete('category-products/{id}', [CategoryProductController::class, 'destroy']);

    // Routes untuk ProductController
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::post('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
});
