<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RecruitmentCsvImport
{
    protected IReader $reader;
    protected Worksheet $activeWorksheet;
    protected Collection $data;
    private Collection $occupations;
    private Collection $workingLocations;

    public function __construct()
    {
        $this->reader = IOFactory::createReader('Csv');
        $this->data = new Collection();
    }

    public function load($file)
    {
        $this->activeWorksheet = $this->reader->load($file)->getActiveSheet();
        $this->data->push(...$this->activeWorksheet->toArray());

        $this->prepare();

        return $this;
    }

    /**
     * Bind keys to values
     *
     * @return void
     */
    protected function bindKeysToValues(): void
    {
        $this->data->transform(fn ($item) => array_combine($this->fields(), $item));
    }

    /**
     * Define attributes
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            'number',
            'title',
            'sub_title',
            'content',
            'is_published',
            'publish_start_date',
            'publish_end_date',
            'contact_branch_id',
            'branch.name',
            'contact_employee_id',
            'employee.name',
            'salary_type',
            'salary',
            'monthly_salary',
            'yearly_salary',
            'has_referral_fee',
            'referral_fee_type',
            'referral_fee_note',
            'referral_fee_by_value',
            'has_refund',
            'refund_note',
            'contact_email',
            'contact_phone_number',
            'holiday',
            'welfare',
            'employment_type',
            'employment_note',
            'labor_contract_type',
            'video_url',
            'image_1_url',
            'image_2_url',
            'image_3_url',
            'image_1_caption',
            'image_2_caption',
            'image_3_caption',
            'created_at',
            'occupations.*.id',
            'occupations.*.name',
            'working_locations.*.id',
            'working_locations.*.name',
            'working_locations.*.district.id',
            'working_locations.*.district.name',
            'working_locations.*.district.province.id',
            'working_locations.*.district.province.name',
            'working_locations.*.pivot.detail_address',
            'working_locations.*.pivot.map_url',
            'working_locations.*.pivot.note',
        ];
    }

    /**
     * Prepare data for processing
     *
     * @return void
     */
    private function prepare(): void
    {
        // Remove the first element
        $this->data->shift();

        $this->bindKeysToValues();

        $this->prepareOccupations();

        $this->prepareWorkingLocations();

        $this->prepareRecruitments();
    }

    /**
     * Prepare occupation data
     *
     * @return void
     */
    private function prepareOccupations(): void
    {
        $this->occupations = $this->data
            ->map(fn ($occupation) =>
                collect($occupation)
                    ->filter(fn ($v, $k) =>
                        !strcmp($k, 'number') ||
                        str_contains($k, 'occupations.*')
                            ? true
                            : false
                    )->toArray()
            )
            ->map(fn ($occupation) => [
                'number' => $occupation['number'],
                'id' => $occupation['occupations.*.id'],
                'name' => $occupation['occupations.*.name'],
            ])
            ->filter(fn ($occupation) => !is_null($occupation['id']));
    }

    /**
     * Prepare working location data
     *
     * @return void
     */
    private function prepareWorkingLocations(): void
    {
        $this->workingLocations = $this->data
            ->map(fn ($workingLocation) =>
                collect($workingLocation)
                    ->filter(fn ($v, $k) =>
                        !strcmp($k, 'number') ||
                        str_contains($k, 'working_locations.*')
                            ? true
                            : false
                    )->toArray()
            )
            ->map(fn ($workingLocation) => [
                'number' => $workingLocation['number'],
                'id' => $workingLocation['working_locations.*.id'],
                'name' => $workingLocation['working_locations.*.name'],
                'detail_address' => $workingLocation['working_locations.*.pivot.detail_address'],
                'map_url' => $workingLocation['working_locations.*.pivot.map_url'],
                'note' => $workingLocation['working_locations.*.pivot.note'],
            ])
            ->filter(fn ($workingLocation) => !is_null($workingLocation['id']));
    }

    /**
     * Prepare recruitment data
     *
     * @return void
     */
    private function prepareRecruitments(): void
    {
        $this->data = $this->data
            ->unique('number')
            ->values()
            ->map(fn ($recruit) =>
                collect($recruit)
                    ->filter(fn ($v, $k) =>
                        str_contains($k, '*') ? false : true
                    )->toArray()
            )
            ->map(function ($recruit) {
                $this->occupations->each(function ($v) use (&$recruit) {
                    if ($recruit['number'] === $v['number']) {
                        $recruit['recruitment_occupations'][] = $v['id'];
                    };
                });
                return $recruit;
            })
            ->map(function ($recruit) {
                $this->workingLocations->each(function ($v) use (&$recruit) {
                    if ($recruit['number'] === $v['number']) {
                        $recruit['working_locations'][] = [
                            'ward_id' => $v['id'],
                            'detail_address' => $v['detail_address'],
                            'map_url' => $v['map_url'],
                            'note' => $v['note'],
                        ];
                    };
                });
                return $recruit;
            });
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data->toArray();
    }
}
