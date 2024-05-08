<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;

abstract class BaseExport
{
    public const RELATION_BELONGSTO = 'BelongsTo';
    public const RELATION_HASONE = 'HasOne';
    public const RELATION_HASMANY = 'HasMany';
    public const RELATION_BELONGSTOMANY = 'BelongsToMany';

    protected Spreadsheet $spreadsheet;
    protected Worksheet $activeWorksheet;
    protected IWriter $writer;
    protected int $currentRow;
    protected array $columns = [];
    protected array $keys = [];

    public function __construct($ext)
    {
        $this->spreadsheet = new Spreadsheet();
        $this->activeWorksheet = $this->spreadsheet->getActiveSheet();
        $this->writer = IOFactory::createWriter($this->spreadsheet, $ext);

        $this->currentRow = 1;
        [$this->keys, $this->columns] = Arr::divide($this->columns());

        $this->headings();
    }

    /**
     * Handling data
     *
     * @param  Collection  $collection
     * @param  string|null $fileName
     * @return self
     */
    abstract public function handle(Collection $collection): self;

    /**
     * Define columns
     *
     * @return array
     */
    abstract public function columns(): array;

    /**
     * Set title columns
     *
     * @return void
     */
    public function headings(): void
    {
        // Initialize the column's index value = 1
        $columnIndex = 1;
        foreach ($this->columns as $column) {
            // Set the column name corresponding to each attribute
            $this->setCellValue($columnIndex, $this->currentRow, $column);
            // Increase the value of the column's index
            $columnIndex++;
        }
        // Increase the value of the row's index by 1
        $this->currentRow += 1;
    }

    /**
     * Set cell value
     *
     * @param  mixed     $currentCol
     * @param  mixed     $currentRow
     * @param  mixed     $value
     * @return Worksheet
     */
    public function setCellValue($currentCol, $currentRow, $value): Worksheet
    {
        $this->activeWorksheet->setCellValue([$currentCol, $currentRow], $value);
        return $this->activeWorksheet;
    }

    /**
     * Save file
     *
     * @param  string $fileName
     * @return void
     */
    public function save(string $fileName): void
    {
        $fileName = $fileName ? $fileName : time();
        $fileName = explode('.', $fileName)[0];
        $fileName = $fileName . '.' . 'csv';
        $this->writer->save($fileName);
    }
}
