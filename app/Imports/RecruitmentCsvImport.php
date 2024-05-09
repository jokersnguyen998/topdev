<?php

namespace App\Imports;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RecruitmentCsvImport
{
    protected $reader;
    protected $spreadsheet;
    protected $activeWorksheet;

    public function __construct()
    {
        $this->reader = IOFactory::createReader('Csv');
    }

    public function load($file)
    {
        $this->activeWorksheet = $this->reader->load($file)->getActiveSheet();

        $data = $this->activeWorksheet->toArray();
        array_shift($data);
        
        $data = array_map(function ($recruit) {
            return array_combine($this->fields(), $recruit);
        }, $data);

        dd($data);
    }

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
            'branch.name',
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
            'working_locations.*.district.name',
            'working_locations.*.district.province.name',
            'working_locations.*.pivot.detail_address',
            'working_locations.*.pivot.map_url',
            'working_locations.*.pivot.note',
        ];
    }
}
