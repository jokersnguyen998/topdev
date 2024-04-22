<?php

use App\Http\Controllers\Buyer\RecruitmentController as BuyerRecruitmentController;
use App\Http\Controllers\Seller\CompanyJobIntroductionLicenseController as SellerCompanyJobIntroductionLicenseController;
use App\Http\Controllers\Seller\BranchJobIntroductionLicenseController as SellerBranchJobIntroductionLicenseController;
use App\Http\Controllers\Buyer_Seller\AuthController as BuyerSellerAuthController;
use App\Http\Controllers\Buyer_Seller\CompanyController as BuyerSellerCompanyController;
use App\Http\Controllers\Buyer_Seller\BranchController as BuyerSellerBranchController;
use App\Http\Controllers\Worker\AuthController as WorkerAuthController;
use App\Http\Controllers\LP\LandingPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/buyer')->as('buyer.')->middleware(['auth:sanctum'])->group(function () {
    Route::prefix('/recruitments')->as('recruitments.')->group(function () {
        Route::controller(BuyerRecruitmentController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{recruitment_id}', 'show')->name('show')->whereNumber('recruitment_id');
            Route::put('/{recruitment_id}', 'update')->name('update')->whereNumber('recruitment_id');
        });
    });
});

Route::prefix('/seller')->as('seller.')->middleware(['auth:sanctum', 'can:valid-license'])->group(function () {
    Route::prefix('/companies')->as('company.')->group(function () {
        Route::controller(SellerCompanyJobIntroductionLicenseController::class)->group(function () {
            Route::put('/job-introduction-license', 'update')->name('job-introduction-license.update')->withoutMiddleware(['can:valid-license']);
        });
    });

    Route::prefix('/branches')->as('branch.')->group(function () {
        Route::controller(SellerBranchJobIntroductionLicenseController::class)->group(function () {
            Route::put('/{branch_id}/job-introduction-license', 'update')->name('job-introduction-license.update')->whereNumber('branch_id');
        });
    });
});

Route::prefix('/buyer-seller')->as('buyer-seller.')->middleware(['auth:sanctum'])->group(function () {
    Route::controller(BuyerSellerAuthController::class)->group(function () {
        Route::post('/login', 'login')->withoutMiddleware(['auth:sanctum']);
        Route::delete('/logout', 'logout');
    });

    Route::prefix('/companies')->as('company.')->group(function () {
        Route::controller(BuyerSellerCompanyController::class)->group(function () {
            Route::get('/me', 'show')->name('show');
            Route::put('/me', 'update')->name('update');
        });
    });

    Route::prefix('/branches')->as('branch.')->group(function () {
        Route::controller(BuyerSellerBranchController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{branch_id}', 'show')->name('show')->whereNumber('branch_id');
            Route::put('/{branch_id}', 'update')->name('update')->whereNumber('branch_id');
        });
    });
});

Route::prefix('/worker')->as('worker.')->middleware(['auth:sanctum'])->group(function () {
    Route::controller(WorkerAuthController::class)->group(function () {
        Route::post('/register', 'register')->withoutMiddleware(['auth:sanctum']);
        Route::post('/login', 'login')->withoutMiddleware(['auth:sanctum']);
        Route::delete('/logout', 'logout');
    });
});

Route::prefix('/lp')->group(function () {
    Route::controller(LandingPageController::class)->group(function () {
        Route::post('/using-applications', 'storeCompany');
    });
});
