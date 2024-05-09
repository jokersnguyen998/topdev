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
        $this->spreadsheet = $this->reader->load($file);
        $this->activeWorksheet = $this->spreadsheet->getActiveSheet();
        $data = $this->activeWorksheet->toArray();
        $a = array_shift($data);
        dd($data);
    }

}
