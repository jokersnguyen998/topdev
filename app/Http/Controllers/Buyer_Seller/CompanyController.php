<?php

namespace App\Http\Controllers\Buyer_Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer_Seller\UpdateCompanyRequest;
use App\Services\Buyer_Seller\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    protected CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Show company info
     *
     * @param  Request      $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $company = $this->companyService->show($request);
        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * Update company info
     *
     * @param  UpdateCompanyRequest $request
     * @return JsonResponse
     */
    public function update(UpdateCompanyRequest $request): JsonResponse
    {
        $this->companyService->update($request);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
