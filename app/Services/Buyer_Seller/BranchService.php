<?php

namespace App\Services\Buyer_Seller;

use App\Http\Requests\Buyer_Seller\UpdateBranchRequest;
use App\Http\Resources\Buyer_Seller\BranchResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BranchService
{
    /**
     * List of branches
     *
     * @param  Request                     $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return BranchResource::collection($request->user()->company->branches->load([
            'ward.district.province',
            'branchJobIntroductionLicense.ward.district.province',
        ]));
    }

    /**
     * Show branch info
     *
     * @param  Request        $request
     * @param  int            $id
     * @return BranchResource
     *
     * @throws NotFoundHttpException
     */
    public function show(Request $request, int $id): BranchResource
    {
        return new BranchResource($request->user()->company->branches()->findOrFail($id)->load([
            'ward.district.province',
            'company',
        ]));
    }

    /**
     * Update branch info
     *
     * @param  UpdateBranchRequest $request
     * @param  int                 $id
     * @return void
     */
    public function update(UpdateBranchRequest $request, int $id): void
    {
        $request->user()->company->branches()->findOrFail($id)->update($request->validated());
    }
}
