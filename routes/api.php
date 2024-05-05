<?php

use App\Http\Controllers\Buyer\RecruitmentController as BuyerRecruitmentController;
use App\Http\Controllers\Buyer\BookingController as BuyerBookingController;
use App\Http\Controllers\Buyer\MeetingRoomController as BuyerMeetingRoomController;
use App\Http\Controllers\Seller\CompanyJobIntroductionLicenseController as SellerCompanyJobIntroductionLicenseController;
use App\Http\Controllers\Seller\BranchJobIntroductionLicenseController as SellerBranchJobIntroductionLicenseController;
use App\Http\Controllers\Buyer_Seller\AuthController as BuyerSellerAuthController;
use App\Http\Controllers\Buyer_Seller\CompanyController as BuyerSellerCompanyController;
use App\Http\Controllers\Buyer_Seller\BranchController as BuyerSellerBranchController;
use App\Http\Controllers\Buyer_Seller\EmployeeController as BuyerSellerEmployeeController;
use App\Http\Controllers\Worker\AuthController as WorkerAuthController;
use App\Http\Controllers\Worker\MeController as WorkerMeController;
use App\Http\Controllers\Worker\ReferralConnectionController as WorkerReferralConnectionController;
use App\Http\Controllers\LP\LandingPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Buyer Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('/buyer')->as('buyer.')->middleware(['auth:sanctum'])->group(function () {
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

    Route::prefix('/employees')->as('employee.')->group(function () {
        Route::controller(BuyerSellerEmployeeController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{employee_id}', 'show')->name('show')->whereNumber('employee_id');
            Route::put('/{employee_id}', 'update')->name('update')->whereNumber('employee_id');
            Route::delete('/{employee_id}', 'delete')->name('delete')->whereNumber('employee_id');
        });
    });

    Route::prefix('/recruitments')->as('recruitment.')->group(function () {
        Route::controller(BuyerRecruitmentController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{recruitment_id}', 'show')->name('show')->whereNumber('recruitment_id');
            Route::put('/{recruitment_id}', 'update')->name('update')->whereNumber('recruitment_id');
        });
    });

    Route::prefix('/bookings')->as('booking.')->group(function () {
        Route::controller(BuyerBookingController::class)->group(function () {
            Route::post('/', 'store')->name('store');
            Route::get('/{booking_id}', 'show')->name('show')->whereNumber('booking_id');
            Route::put('/{booking_id}', 'update')->name('update')->whereNumber('booking_id');
            Route::delete('/{booking_id}', 'delete')->name('delete')->whereNumber('booking_id');
        });
    });

    Route::prefix('/meeting-rooms')->as('meeting-rooms.')->group(function () {
        Route::controller(BuyerMeetingRoomController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{meeting_room_id}', 'show')->name('show')->whereNumber('meeting_room_id');
            Route::put('/{meeting_room_id}', 'update')->name('update')->whereNumber('meeting_room_id');
            Route::delete('/{meeting_room_id}', 'delete')->name('delete')->whereNumber('meeting_room_id');
        });
    });
});


/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('/seller')->as('seller.')->middleware(['auth:sanctum', 'can:valid-license'])->group(function () {
    Route::prefix('/companies')->as('company.')->group(function () {
        Route::controller(BuyerSellerCompanyController::class)->withoutMiddleware(['can:valid-license'])->group(function () {
            Route::get('/me', 'show')->name('show');
            Route::put('/me', 'update')->name('update');
        });

        Route::controller(SellerCompanyJobIntroductionLicenseController::class)->withoutMiddleware(['can:valid-license'])->group(function () {
            Route::put('/job-introduction-license', 'update')->name('job-introduction-license.update');
        });
    });

    Route::prefix('/branches')->as('branch.')->group(function () {
        Route::controller(BuyerSellerBranchController::class)->withoutMiddleware(['can:valid-license'])->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{branch_id}', 'show')->name('show')->whereNumber('branch_id');
            Route::put('/{branch_id}', 'update')->name('update')->whereNumber('branch_id');
        });

        Route::controller(SellerBranchJobIntroductionLicenseController::class)->group(function () {
            Route::put('/{branch_id}/job-introduction-license', 'update')->name('job-introduction-license.update')->whereNumber('branch_id');
        });
    });

    Route::prefix('/employees')->as('employee.')->group(function () {
        Route::controller(BuyerSellerEmployeeController::class)->withoutMiddleware(['can:valid-license'])->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{employee_id}', 'show')->name('show')->whereNumber('employee_id');
            Route::put('/{employee_id}', 'update')->name('update')->whereNumber('employee_id');
            Route::delete('/{employee_id}', 'delete')->name('delete')->whereNumber('employee_id');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Buyer_Seller Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('/buyer-seller')->as('buyer-seller.')->middleware(['auth:sanctum'])->group(function () {
    Route::controller(BuyerSellerAuthController::class)->group(function () {
        Route::post('/login', 'login')->withoutMiddleware(['auth:sanctum']);
        Route::delete('/logout', 'logout');
    });
});

/*
|--------------------------------------------------------------------------
| Worker Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('/worker')->as('worker.')->middleware(['auth:sanctum'])->group(function () {
    Route::controller(WorkerAuthController::class)->group(function () {
        Route::post('/register', 'register')->withoutMiddleware(['auth:sanctum']);
        Route::post('/login', 'login')->withoutMiddleware(['auth:sanctum']);
        Route::delete('/logout', 'logout');
    });

    Route::prefix('/me')->as('me.')->group(function () {
        Route::controller(WorkerMeController::class)->group(function () {
            Route::prefix('/academic-levels')->as('academic-level.')->group(function () {
                Route::put('/', 'updateAcademicLevel')->name('update');
            });

            Route::prefix('work-experiences')->as('work-experience.')->group(function () {
                Route::put('/', 'updateWorkExperience')->name('update');
            });

            Route::prefix('licenses')->as('license.')->group(function () {
                Route::put('/', 'updateLicense')->name('update');
            });

            Route::prefix('skills')->as('skill.')->group(function () {
                Route::put('/', 'updateSkill')->name('update');
            });

            Route::prefix('info')->as('info.')->group(function () {
                Route::put('/', 'updateInfo')->name('update');
            });
        });
    });

    Route::prefix('referral-connections')->as('referral-connection.')->group(function () {
        Route::controller(WorkerReferralConnectionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::delete('/{referral_connection_id}', 'delete')->name('delete')->whereNumber('referral_connection_id');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Landing Page Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('/lp')->group(function () {
    Route::controller(LandingPageController::class)->group(function () {
        Route::post('/using-applications', 'storeCompany');
    });
});
