<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;

final class RecruitmentCsvExport
{
    protected Spreadsheet $spreadsheet;
    protected Worksheet $activeWorksheet;
    protected IWriter $writer;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->activeWorksheet = $this->spreadsheet->getActiveSheet();
        $this->writer = IOFactory::createWriter($this->spreadsheet, 'Csv');
    }

    public function handle(Collection $collection, ?string $fileName = null)
    {
        // dd();
        $maxColumn = count($collection[0]->toArray());
        $collection->each(function (Model $item) use ($maxColumn) {
            dd($item->getFillable());
            $branch = $item->getRelation('branch')->getAttributes();
            $employee = $item->getRelation('employee')->getAttributes();
            $occupations = $item->getRelation('occupations');
            $workingLocations = $item->getRelation('workingLocations');

            $data = $item->toArray();
            for ($i = 0; $i < $maxColumn; $i++) {
                $column = Coordinate::stringFromColumnIndex($i);
                $this->activeWorksheet->setCellValue($column . $i + 1, $data[$i]);
            }

            $maxRaw = max($workingLocations->count(), $occupations->count());
        });
        $fileName = $fileName ?? time() . '.' . 'csv';
        $this->activeWorksheet->setCellValue('A1', 'Hello World !');
        $this->writer->save($fileName);

        return $fileName;
    }

    private function setColumn(): array
    {
        return [
            '#' => '#',
            'number' => 'Recruitment No.',
            'title' => 'Title',
            'sub_title' => 'Sub Title',
            'content' => 'Content',
            'is_published' => 'Published Status',
            'publish_start_date' => 'Publish Start Date',
            'publish_end_date' => 'Publish End Date',
            'branch_id' => 'Branch ID',
            'salary_type' => 'Salary Type',
            'salary' => 'Salary',
            'monthly_salary' => 'Monthly Salary',
            'yearly_salary' => 'Yearly Salary',
            'has_referral_fee' => 'Referral Fee',
            'referral_fee_type' => 'Referral Fee Type',
            'referral_fee_note' => 'Referral Fee Note',
            'referral_fee_by_value' => 'Referral Fee Value',
            'has_refund' => 'Refund Fee',
            'has_note' => 'Refund Note',
            'contact_email' => 'Contact Email',
            'contact_phone_number' => 'Contact Phone Number',
            'holiday' => 'Holiday',
            'welfare' => 'Welfare',
            'employment_type' => 'Employment Type',
            'employment_note' => 'Employment Note',
            'labor_contract_type' => 'Labor Contract Type',
            'video_url' => 'Video Url',
            'image_1_url' => 'Image 1 Url',
            'image_2_url' => 'Image 2 Url',
            'image_3_url' => 'Image 3 Url',
            'image_1_caption' => 'Image 1 Caption',
            'image_2_caption' => 'Image 2 Caption',
            'image_3_caption' => 'Image 3 Caption',
            'created_at' => 'Created At'
        ];
    }
}
