<?php

namespace App\Services\Buyer;

use App\Enums\AdministrativeUnitType;
use App\Enums\EmploymentType;
use App\Enums\LaborContractType;
use App\Enums\ReferralFeeType;
use App\Enums\SalaryType;
use App\Exports\RecruitmentCsvExport;
use App\Http\Requests\Buyer\ImportRecruitmentRequest;
use App\Http\Requests\Buyer\ImportRecruitmentValidator;
use App\Http\Requests\Buyer\StoreRecruitmentRequest;
use App\Http\Requests\Buyer\UpdateRecruitmentRequest;
use App\Http\Resources\Buyer\RecruitmentResource;
use App\Imports\RecruitmentCsvImport;
use App\Models\Recruitment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
     * @return RecruitmentResource
     *
     * @throws NotFoundHttpException
     */
    public function update(UpdateRecruitmentRequest $request, int $id): RecruitmentResource
    {
        $recruitment = DB::transaction(function () use ($request, $id) {
            $originRecruitment = Recruitment::query()
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
    public function import(ImportRecruitmentRequest $request)
    {
        $data = (new RecruitmentCsvImport)->load($request->file)->toArray();

        $validator = validator($data, [
            '*.contact_branch_id' => [
                'required',
                Rule::exists('branches', 'id')->where('company_id', $request->user()->company_id),
            ],
            '*.contact_employee_id' => [
                'required',
                Rule::exists('employees', 'id')->where('company_id', $request->user()->company_id),
            ],
            '*.is_published' => [
                'required',
                'boolean',
                'published_with_all:publish_start_date,publish_end_date',
            ],
            '*.publish_start_date' => 'required|date_format:Y-m-d',
            '*.publish_end_date' => 'required|date_format:Y-m-d|after:publish_start_date',
            '*.number' => [
                'required',
                'max:50',
                Rule::unique('recruitments', 'number')
                    ->where('company_id', $request->user()->company_id)
            ],
            '*.title' => 'required|max:100',
            '*.sub_title' => 'required|max:100',
            '*.content' => 'required|max:800',
            '*.salary_type' => [
                'required',
                Rule::enum(SalaryType::class),
            ],
            '*.salary' => 'required|digits_between:7,10',
            '*.monthly_salary' => 'required|digits_between:7,10',
            '*.yearly_salary' => 'required|digits_between:7,10',
            '*.has_referral_fee' => 'required|boolean',
            '*.referral_fee_type' => [
                'nullable',
                Rule::enum(ReferralFeeType::class),
                fn ($attr, $value, $message, $fail) => dd(data_get($data, $attr)),
                // Rule::requiredIf(fn ($value) => dd($value)),
                // Rule::requiredIf(fn ($value) => isset($value['has_referral_fee'])),
                // Rule::prohibitedIf(fn ($value) => !isset($data['has_referral_fee'])),
            ],
            // '*.referral_fee_note' => [
            //     'nullable',
            //     'max:800',
            //     'required_if:*.has_referral_fee,true',
            //     // Rule::requiredIf($data['has_referral_fee']),
            // ],
            // '*.referral_fee_by_value' => [
            //     'nullable',
            //     'digits_between:7,10',
            //     // Rule::requiredIf(fn ($value) => dd($value['referral_fee_type'])),
            //     Rule::requiredIf(fn ($value) => $value['referral_fee_type'] === ReferralFeeType::MONEY->value),
            //     Rule::prohibitedIf(fn ($value) => $value['referral_fee_type'] !== ReferralFeeType::MONEY->value),
            // ],
            // '*.referral_fee_percent' => [
            //     'nullable',
            //     'digits_between:1,100',
            //     Rule::requiredIf(fn ($value) => $value['referral_fee_type'] === ReferralFeeType::PERCENT->value),
            //     Rule::prohibitedIf(fn ($value) => $value['referral_fee_type'] !== ReferralFeeType::PERCENT->value),
            // ],
            // '*.has_refund' => 'required|boolean',
            // '*.refund_note' => [
            //     'nullable',
            //     'max:800',
            //     Rule::requiredIf(fn ($value) => $value['has_refund']),
            // ],
            '*.contact_email' => 'nullable|email|max:100',
            '*.contact_phone_number' => 'nullable|digits_between:10,12',
            '*.holiday' => 'nullable|max:800',
            '*.welfare' => 'nullable|max:800',
            '*.employment_type' => [
                'required',
                Rule::enum(EmploymentType::class),
            ],
            '*.employment_note' => 'nullable|max:800',
            '*.labor_contract_type' => [
                'required',
                Rule::enum(LaborContractType::class),
            ],
            '*.video_url' => 'nullable|url|max:255',
            '*.image_1_url' => 'nullable|url|max:255',
            '*.image_2_url' => 'nullable|url|max:255',
            '*.image_3_url' => 'nullable|url|max:255',
            '*.image_1_caption' => 'nullable|max:100',
            '*.image_2_caption' => 'nullable|max:100',
            '*.image_3_caption' => 'nullable|max:100',

            '*.recruitment_occupations.*' => 'nullable|exists:occupations,id',

            '*.working_locations.*' => 'nullable|array',
            '*.working_locations.*.ward_id' => [
                'required',
                Rule::exists('administrative_units', 'id')
                    ->whereIn('type', AdministrativeUnitType::wards()),
            ],
            '*.working_locations.*.detail_address' => 'required|max:255',
            '*.working_locations.*.map_url' => 'nullable|max:255',
            '*.working_locations.*.note' => 'nullable|max:500',
        ]);

        dd($validator->errors());
        dd($data);
    }
}
