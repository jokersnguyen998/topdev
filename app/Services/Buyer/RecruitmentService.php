<?php

namespace App\Services\Buyer;

use App\Http\Requests\Buyer\StoreRecruitmentRequest;
use App\Http\Requests\Buyer\UpdateRecruitmentRequest;
use App\Http\Resources\Buyer\RecruitmentResource;
use App\Models\Recruitment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecruitmentService
{
    /**
     * List of recruitments
     *
     * @param  Request                     $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return RecruitmentResource::collection(
            Recruitment::query()
                ->whereIn('contact_branch_id', $request->user()->company->branches->pluck('id')->toArray())
                ->with([
                    'branch.ward.district.province',
                    'employee.ward.district.province',
                ])
                ->get()
        );
    }

    /**
     * Store recruitment info
     *
     * @param  StoreRecruitmentRequest $request
     * @return RecruitmentResource
     */
    public function store(StoreRecruitmentRequest $request): RecruitmentResource
    {
        return new RecruitmentResource(Recruitment::query()->create($request->validated()));
    }

    /**
     * Show recruitment info
     *
     * @param  Request     $request
     * @param  int         $id
     * @return Recruitment
     *
     * @throws NotFoundHttpException
     */
    public function show(Request $request, int $id): RecruitmentResource
    {
        return new RecruitmentResource(
            Recruitment::query()
                ->whereIn('contact_branch_id', $request->user()->company->branches->pluck('id')->toArray())
                ->with(['branch.ward.district.province', 'employee.ward.district.province'])
                ->findOrFail($id)
        );
    }

    /**
     * Update recruitment info
     *
     * @param  UpdateRecruitmentRequest $request
     * @param  int                      $id
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function update(UpdateRecruitmentRequest $request, int $id): void
    {
        Recruitment::query()
            ->whereIn('contact_branch_id', $request->user()->company->branches->pluck('id')->toArray())
            ->whereKey($id)
            ->update($request->validated());
    }
}
