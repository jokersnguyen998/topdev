<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

final class RecruitmentCsvExport extends BaseExport
{
    public function __construct()
    {
        parent::__construct('Csv');

        // $this->writer->setDelimiter(';');
        // $this->writer->setEnclosure('"');
        // $this->writer->setLineEnding("\r\n");
        // $this->writer->setSheetIndex(0);
        // $this->writer->setPreCalculateFormulas(false);
        $this->writer->setUseBOM(true);
    }

    /**
     * Handling data
     *
     * @param  Collection $collection
     * @return self
     */
    public function handle(Collection $collection): self
    {
        foreach ($collection as $recruit) {
            $recruitRelations = $recruit->getRelations();
            $maxRowPerRecruit = $this->currentRow + $this->maxRawOfModel($recruit, $recruitRelations);
            for ($col = 1; $col <= count($this->columns); $col++) {

                $index = 0;
                $indexRowPerRecruit = 0;
                for ($row = $this->currentRow; $row < $maxRowPerRecruit; $row++) {

                    $value = $recruit;
                    $keys = explode('.', $this->keys[$col - 1]);
                    foreach ($keys as $keyIndex => $key) {

                        if ($key === '*') {
                            if (!isset($value[$index])) break 2;
                            $value = $value[$index];
                            $index++;
                            continue;
                        }

                        $haystack = $keyIndex != 0
                            ? array_keys($value->getRelations())
                            : array_keys($recruitRelations);

                        $key = in_array(Str::camel($key), $haystack)
                            ? Str::camel($key)
                            : Str::snake($key);

                        $value = $value[$key];

                        if (is_bool($value)) {
                            $value = (int) $value;
                        }

                        if ($value instanceof Carbon) {
                            $value = $value->timezone('Asia/Ho_Chi_Minh')->toDateTimeString();
                        }

                    }

                    $cell = $this->getCell($col, $row)->setValue($value);

                    if (is_array($v = $this->columns[$col - 1]) && isset($v['type'])) {
                        $cell
                            ->getStyle()
                            ->getNumberFormat()
                            ->setFormatCode($v['type']);
                    }

                    $indexRowPerRecruit++;
                }
            }

            $this->currentRow = $maxRowPerRecruit;
        }

        return $this;
    }

    /**
     * Define columns
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            'number'                 => 'No.',
            'title'                  => 'Title',
            'sub_title'              => 'Sub Title',
            'content'                => 'Content',
            'is_published'           => 'Published Status',
            'publish_start_date'     => 'Publish Start Date',
            'publish_end_date'       => 'Publish End Date',
            'branch.name'            => 'Branch Name',
            'employee.name'          => 'Employee Name',
            'salary_type'            => 'Salary Type',
            'salary'                 => 'Salary',
            'monthly_salary'         => 'Monthly Salary',
            'yearly_salary'          => 'Yearly Salary',
            'has_referral_fee'       => 'Referral Fee',
            'referral_fee_type'      => 'Referral Fee Type',
            'referral_fee_note'      => 'Referral Fee Note',
            'referral_fee_by_value'  => 'Referral Fee By Value',
            'has_refund'             => 'Refund Fee',
            'refund_note'            => 'Refund Note',
            'contact_email'          => 'Contact Email',
            'contact_phone_number'   => 'Contact Phone Number',
            'holiday'                => 'Holiday',
            'welfare'                => 'Welfare',
            'employment_type'        => 'Employment Type',
            'employment_note'        => 'Employment Note',
            'labor_contract_type'    => 'Labor Contract Type',
            'video_url'              => 'Video Url',
            'image_1_url'            => 'Image 1 Url',
            'image_2_url'            => 'Image 2 Url',
            'image_3_url'            => 'Image 3 Url',
            'image_1_caption'        => 'Image 1 Caption',
            'image_2_caption'        => 'Image 2 Caption',
            'image_3_caption'        => 'Image 3 Caption',
            'created_at'             => 'Created At',
            'occupations.*.id'                           => 'Occupation ID',
            'occupations.*.name'                         => 'Occupation Name',
            'working_locations.*.id'                     => 'Location ID',
            'working_locations.*.name'                   => 'Ward',
            'working_locations.*.district.name'          => 'District',
            'working_locations.*.district.province.name' => 'Province',
            'working_locations.*.pivot.detail_address'   => 'Detail Address',
            'working_locations.*.pivot.map_url'          => 'Map URL',
            'working_locations.*.pivot.note'             => 'Location Note',
        ];
    }
}
