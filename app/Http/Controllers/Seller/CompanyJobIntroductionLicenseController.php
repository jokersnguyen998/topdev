<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\UpdateCompanyJobIntroductionLicenseRequest;
use App\Services\Seller\CompanyJobIntroductionLicenseService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CompanyJobIntroductionLicenseController extends Controller
{
    protected CompanyJobIntroductionLicenseService $companyJobIntroductionLicenseService;

    public function __construct(CompanyJobIntroductionLicenseService $companyJobIntroductionLicenseService)
    {
        $this->companyJobIntroductionLicenseService = $companyJobIntroductionLicenseService;
    }

    /**
     * Update company job introduction license info
     *
     * @param  UpdateCompanyJobIntroductionLicenseRequest $request
     * @return JsonResponse
     */
    public function update(UpdateCompanyJobIntroductionLicenseRequest $request): JsonResponse
    {
        $this->companyJobIntroductionLicenseService->update($request);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
