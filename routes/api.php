<?php

use App\Http\Controllers\Buyer_Seller\AuthController;
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
    Route::post('/register', [AuthController::class, 'register'])->withoutMiddleware(['auth:sanctum']);
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware(['auth:sanctum']);
});
