<?php

namespace App\Http\Controllers\LP;

use App\Http\Controllers\Controller;
use App\Http\Requests\LP\StoreCompanyRequest;
use App\Services\LP\LandingPageService;
use Symfony\Component\HttpFoundation\Response;

class LandingPageController extends Controller
{
    protected LandingPageService $companyService;

    public function __construct(LandingPageService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function storeCompany(StoreCompanyRequest $request): \Illuminate\Http\Response
    {
        $this->companyService->storeCompany($request->validated());
        return response(null, Response::HTTP_CREATED);
    }
}
