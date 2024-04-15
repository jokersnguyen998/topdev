<?php

use App\Http\Controllers\Buyer_Seller\AuthController as BuyerSellerAuthController;
use App\Http\Controllers\Worker\AuthController as WorkerAuthController;
use App\Http\Controllers\LP\LandingPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/buyer')->middleware(['auth:sanctum'])->group(function () {
});

Route::prefix('/seller')->middleware(['auth:sanctum'])->group(function () {
});

Route::prefix('/buyer-seller')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/login', [BuyerSellerAuthController::class, 'login'])->withoutMiddleware(['auth:sanctum']);
    Route::delete('/logout', [BuyerSellerAuthController::class, 'logout']);
});

Route::prefix('/worker')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/register', [WorkerAuthController::class, 'register'])->withoutMiddleware(['auth:sanctum']);
    Route::post('/login', [WorkerAuthController::class, 'login'])->withoutMiddleware(['auth:sanctum']);
    Route::delete('/logout', [WorkerAuthController::class, 'logout']);
});

Route::prefix('/lp')->group(function () {
    Route::controller(LandingPageController::class)->group(function () {
        Route::post('/using-applications', 'storeCompany');
    });
});
