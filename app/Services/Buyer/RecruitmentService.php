<?php

namespace App\Services\Buyer;

use App\Http\Requests\Buyer\StoreRecruitmentRequest;
use App\Http\Requests\Buyer\UpdateRecruitmentRequest;
use App\Models\Recruitment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecruitmentService
{
    /**
     * List of recruitments
     * 
     * @param  Request    $request
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        $branchId = $request->user()->company->branches->pluck('id')->toArray();
        return Recruitment::query()->whereIn('contact_branch_id', $branchId)->get();
    }

    /**
     * Store recruitment info
     * 
     * @param  StoreRecruitmentRequest $request
     * @return Recruitment
     */
    public function store(StoreRecruitmentRequest $request): Recruitment
    {
        return Recruitment::query()->create($request->validated());
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
    public function show(Request $request, int $id): Recruitment
    {
        $request->validate([
            'recruitment_id' => [
                'required', 
                Rule::exists('recruitments', 'id')->where('contact_branch_id', $request->user()->branch_id),
            ]
        ]);
        return Recruitment::query()->findOrFail($id);
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
        Recruitment::query()->findOrFail($id)->update($request->validated());
    }
}
