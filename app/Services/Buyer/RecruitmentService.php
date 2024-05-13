<?php

namespace App\Services\Buyer;

use App\Exports\RecruitmentCsvExport;
use App\Http\Requests\Buyer\ImportRecruitmentRequest;
use App\Http\Requests\Buyer\ImportRecruitmentValidator;
use App\Http\Requests\Buyer\StoreRecruitmentRequest;
use App\Http\Requests\Buyer\UpdateRecruitmentRequest;
use App\Http\Resources\Buyer\RecruitmentResource;
use App\Imports\RecruitmentCsvImport;
use App\Jobs\ImportRecruitmentCsv;
use App\Models\Recruitment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
            Recruitment::revised()
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
            $data = $request->validated();
            $data['company_id'] = $request->user()->company_id;

            $recruitment = Recruitment::query()->create($data);

            DB::table('latest_recruitments')->insert([
                'recruitment_id' => $recruitment->id,
                'company_id' => $recruitment->company_id,
                'number' => $recruitment->number,
            ]);

            $recruitment->occupations()->attach($request->recruitment_occupations);

            foreach ($request->working_locations as $item) {
                $recruitment->workingLocations()->attach($item['ward_id'], [
                    'detail_address' => $item['detail_address'],
                    'map_url' => $item['map_url'],
                    'note' => $item['note'],
                ]);
            }

            return $recruitment->load([
                'branch.ward.district.province',
                'employee.ward.district.province',
                'occupations',
                'workingLocations.district.province',
            ]);
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
            Recruitment::revised()
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
     * @return RecruitmentResource
     *
     * @throws NotFoundHttpException
     */
    public function update(UpdateRecruitmentRequest $request, int $id): RecruitmentResource
    {
        $recruitment = DB::transaction(function () use ($request, $id) {
            $originRecruitment = Recruitment::revised()
                ->whereIn('contact_branch_id', $request->user()->company->branches->pluck('id')->toArray())
                ->findOrFail($id);

            $newRecruitment = $this->storeFromOriginRecruitment($request->validated(), $originRecruitment);

            DB::table('latest_recruitments')
                ->where([
                    'number' => $originRecruitment->number,
                    'company_id' => $originRecruitment->company_id,
                ])
                ->update([
                    'recruitment_id' => $newRecruitment->id,
                ]);

            $newRecruitment->occupations()->attach($request->recruitment_occupations);

            foreach ($request->working_locations as $item) {
                $newRecruitment->workingLocations()->attach($item['ward_id'], [
                    'detail_address' => $item['detail_address'],
                    'map_url' => $item['map_url'],
                    'note' => $item['note'],
                ]);
            }

            return $newRecruitment->load([
                'branch.ward.district.province',
                'employee.ward.district.province',
                'occupations',
                'workingLocations.district.province',
            ]);
        });

        return new RecruitmentResource($recruitment);
    }

    /**
     * Store from the original recruitment info
     *
     * @param  array       $data
     * @param  Recruitment $originRecruitment
     * @return Recruitment
     */
    private function storeFromOriginRecruitment(array $data, Recruitment $originRecruitment): Recruitment
    {
        $data['number'] = $originRecruitment->number;
        $data['company_id'] = $originRecruitment->company_id;
        $recruitment = Recruitment::query()->create($data);
        return $recruitment;
    }

    /**
     * Export recruitment info
     *
     * @param  Request $request
     * @param  string  $fileName
     * @return string
     */
    public function export(Request $request, string $fileName): string
    {
        $recruitments = Recruitment::query()
            ->where('company_id', '=', $request->user()->company_id)
            ->with([
                'branch',
                'employee',
                'occupations',
                'workingLocations.district.province',
            ])
            ->get();

        (new RecruitmentCsvExport)->handle($recruitments)->save($fileName);

        return $fileName;
    }

    /**
     * Import recruitment info
     *
     * @param  ImportRecruitmentRequest $request
     * @return void
     */
    public function import(ImportRecruitmentRequest $request): void
    {
        $data = (new RecruitmentCsvImport)->load($request->file)->toArray();
        $validated = (new ImportRecruitmentValidator($data))->validate();
        dd($validated);
        dispatch(new ImportRecruitmentCsv($validated));
    }
}
