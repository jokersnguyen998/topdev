<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\UpdateBranchJobIntroductionLicenseRequest;
use App\Services\Seller\BranchJobIntroductionLicenseService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BranchJobIntroductionLicenseController extends Controller
{
    protected BranchJobIntroductionLicenseService $branchJobIntroductionLicenseService;

    public function __construct(BranchJobIntroductionLicenseService $branchJobIntroductionLicenseService)
    {
        $this->branchJobIntroductionLicenseService = $branchJobIntroductionLicenseService;
    }

    /**
     * Update branch job introduction info
     *
     * @param  UpdateBranchJobIntroductionLicenseRequest $request
     * @param  int                                       $id
     * @return JsonResponse
     */
    public function update(UpdateBranchJobIntroductionLicenseRequest $request, int $id): JsonResponse
    {
        $this->branchJobIntroductionLicenseService->update($request, $id);
        return response()->json()->setStatusCode(Response::HTTP_OK);
    }
}
