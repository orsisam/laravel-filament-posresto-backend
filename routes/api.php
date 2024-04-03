<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/api/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::name('api.')->group(function () {
    // login
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')
        ->group(function () {
            // Product route
            Route::controller(ProductController::class)
                ->name('products.')
                ->prefix('/products')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                });

            // Category route
            Route::controller(CategoryController::class)
                ->prefix('/category')
                ->name('category.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                });
        });
});
