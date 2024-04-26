<?php

namespace App\Services\Buyer_Seller;
use App\Http\Requests\Buyer_Seller\UpdateCompanyRequest;
use App\Http\Resources\Buyer_Seller\CompanyResource;
use Illuminate\Http\Request;

class CompanyService
{
    /**
     * Show company info
     *
     * @param  Request             $request
     * @return CompanyResource
     */
    public function show(Request $request): CompanyResource
    {
        return new CompanyResource($request->user()->company->load([
            'ward.district.province',
            'companyJobIntroductionLicense.ward.district.province',
        ]));
    }

    /**
     * Update company info
     *
     * @param  UpdateCompanyRequest $request
     * @return CompanyResource
     */
    public function update(UpdateCompanyRequest $request): CompanyResource
    {
        $company = $request->user()->company;
        $company->update($request->validated());
        return new CompanyResource($company->load([
            'ward.district.province',
        ]));
    }
}
