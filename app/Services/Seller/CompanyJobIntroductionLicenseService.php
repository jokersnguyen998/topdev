<?php

namespace App\Services\Seller;

use App\Http\Requests\Seller\UpdateCompanyJobIntroductionLicenseRequest;

class CompanyJobIntroductionLicenseService
{
    /**
     * Update company job introduction license info
     *
     * @param  UpdateCompanyJobIntroductionLicenseRequest $request
     * @return void
     */
    public function update(UpdateCompanyJobIntroductionLicenseRequest $request): void
    {
        $request->user()->company->companyJobIntroductionLicense->update($request->validated());
    }
}
