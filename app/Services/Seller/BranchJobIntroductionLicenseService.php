<?php

namespace App\Services\Seller;

use App\Http\Requests\Seller\UpdateBranchJobIntroductionLicenseRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BranchJobIntroductionLicenseService
{
    /**
     * Update company job introduction license info
     *
     * @param  UpdateBranchJobIntroductionLicenseRequest $request
     * @param  int                                       $id
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function update(UpdateBranchJobIntroductionLicenseRequest $request, int $id): void
    {
        $branch = $request->user()->company->branches()->findOrFail($id);
        $branch->branchJobIntroductionLicense->update($request->validated());
    }
}
