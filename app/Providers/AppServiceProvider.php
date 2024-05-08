<?php

namespace App\Providers;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict();
        Model::preventAccessingMissingAttributes(false);
        Gate::define('valid-license', function (Employee $user) {
            $companyJobIntroductionLicense = $user->company?->companyJobIntroductionLicense;
            return $companyJobIntroductionLicense && $companyJobIntroductionLicense->expired_date->gte(today());
        });
    }
}
