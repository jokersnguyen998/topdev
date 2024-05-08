<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Pivot;
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
     * @param  Collection  $collection
     * @return self
     */
    public function handle(Collection $collection): self
    {
        foreach ($collection as $recruit) {
            dd($recruit->workingLocations->first()->toArray());
            $maxRowPerRecruit = $this->currentRow + max($recruit->occupations->count(), $recruit->workingLocations->count());
            for ($col = 1; $col <= count($this->columns); $col++) {
                $index = 0;
                $indexRowPerRecruit = 0;
                for ($row = $this->currentRow; $row < $maxRowPerRecruit; $row++) {
                    // TODO:FIXME: Access properties by dot
                    $keys = explode('.', $this->keys[$col - 1]);
                    if (count($keys) > 1) {
                        $attribute = Str::camel($keys[0]);

                        switch (strtolower($recruit->relationships($attribute)[0])) {
                            case strtolower(parent::RELATION_BELONGSTO):
                            case strtolower(parent::RELATION_HASONE):
                                $value = $recruit->{$attribute}->{$keys[1]};

                                if ($indexRowPerRecruit > 0) {
                                    $value = '';
                                }

                                break;

                            case strtolower(parent::RELATION_HASMANY):
                            case strtolower(parent::RELATION_BELONGSTOMANY):
                                if (!isset($recruit->{$attribute}[$index])) break 2;

                                $value = $recruit->{$attribute}[$index]->{$keys[1]};
                                if ($value instanceof Pivot) {
                                    $value = $value->{$keys[2]};
                                }

                                $index++;
                                break;

                            default:
                                $value = '';
                                break;
                        }

                    } else {

                        $value = $recruit->{$keys[0]};

                        if ($indexRowPerRecruit > 0 && $keys[0] != 'id') {
                            $value = '';
                        }
                    }

                    $this->setCellValue($col, $row, $value);

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
            'occupations.id'         => 'Occupation ID',
            'occupations.name'       => 'Occupation Name',
            'working_locations.id' => 'Location ID',
            'working_locations.name' => 'Ward',
            'working_locations.district.name' => 'District',
            'working_locations.district.province.name' => 'Province',
            'working_locations.pivot.detail_address' => 'Detail Address',
            'working_locations.pivot.map_url' => 'Map URL',
            'working_locations.pivot.note' => 'Location Note',
        ];
    }
}
