<?php

namespace App\Services\Buyer;

use App\Http\Requests\Buyer\StoreRecruitmentRequest;
use App\Http\Requests\Buyer\UpdateRecruitmentRequest;
use App\Http\Resources\Buyer\RecruitmentResource;
use App\Models\Recruitment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        $recruitment = DB::transaction(function () use ($request) {
            $recruitment = Recruitment::query()->create($request->validated());

            $recruitment->occupations()->attach($request->recruitment_occupations);

            foreach ($request->working_locations as $item) {
                $recruitment->workingLocations()->attach($item['ward_id'], [
                    'detail_address' => $item['detail_address'],
                    'map_url' => $item['map_url'],
                    'note' => $item['note'],
                ]);
            }

            return $recruitment;
        });

        return new RecruitmentResource($recruitment);
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

    private function buildWorkingLocationData(?array $data): Collection
    {
        return collect($data)->groupBy('ward_id');
    }
}
