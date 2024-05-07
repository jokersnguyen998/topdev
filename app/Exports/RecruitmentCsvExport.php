<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;

final class RecruitmentCsvExport
{
    protected Spreadsheet $spreadsheet;
    protected Worksheet $activeWorksheet;
    protected IWriter $writer;
    protected int $currentRow;
    protected array $columns = [];
    protected array $attributes = [];

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->activeWorksheet = $this->spreadsheet->getActiveSheet();
        $this->writer = IOFactory::createWriter($this->spreadsheet, 'Csv');
        // $this->writer->setDelimiter(';');
        // $this->writer->setEnclosure('"');
        // $this->writer->setLineEnding("\r\n");
        // $this->writer->setSheetIndex(0);
        $this->writer->setPreCalculateFormulas(false);
        $this->writer->setUseBOM(true);
        $this->currentRow = 1;
        $this->columns = array_values($this->columns());
        $this->attributes = array_keys($this->columns());
        $this->headings();
    }

    public function handle(Collection $collection, string $fileName = null)
    {
        $fileName = $fileName ?? time() . '.' . 'csv';

        foreach ($collection as $item) {
            // $item = $item->toArray();
        }

        $this->writer->save($fileName);

        return $fileName;
    }

    private function headings(): void
    {
        // Initialize the column's index value = 1
        $columnIndex = 1;
        foreach ($this->columns as $column) {
            // If value is array
            if (is_array($column)) {
                // Get all attribute keys from the array
                $keys = array_keys($column);
                foreach (array_values($column) as $i => $v) {
                    // Set the column name corresponding to each attribute
                    $this->setCellValue($columnIndex, $this->currentRow, $column[$keys[$i]]);
                    // Increase the value of the column's index
                    $columnIndex++;
                }
                continue;
            }

            // Set the column name corresponding to each attribute
            $this->setCellValue($columnIndex, $this->currentRow, $column);
            // Increase the value of the column's index
            $columnIndex++;
        }
        // Increase the value of the row's index by 1
        $this->currentRow += 1;
    }

    private function setCellValue($columnIndex, $currentRow, $value): Worksheet
    {
        $this->activeWorksheet->setCellValue([$columnIndex, $currentRow], $value);
        return $this->activeWorksheet;
    }

    public function columns(): array
    {
        return [
            'id' => 'ID',
            'number' => 'Recruitment No.',
            'title' => 'Title',
            'sub_title' => 'Sub Title',
            'content' => 'Content',
            'is_published' => 'Published Status',
            'publish_start_date' => 'Publish Start Date',
            'publish_end_date' => 'Publish End Date',
            'contact_branch_id' => 'Branch ID',
            'contact_employee_id' => 'Employee ID',
            'salary_type' => 'Salary Type',
            'salary' => 'Salary',
            'monthly_salary' => 'Monthly Salary',
            'yearly_salary' => 'Yearly Salary',
            'has_referral_fee' => 'Referral Fee',
            'referral_fee_type' => 'Referral Fee Type',
            'referral_fee_note' => 'Referral Fee Note',
            'referral_fee_by_value' => 'Referral Fee By Value',
            'has_refund' => 'Refund Fee',
            'refund_note' => 'Refund Note',
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
            'created_at' => 'Created At',
            'occupations' => [
                'id' => 'Occupation ID',
                'name' => 'Occupation Name',
            ],
            'working_locations' => [
                'id' => 'Working Location Id',
                'name' => 'Working Location Name',
            ]
        ];
    }
}
