<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;

abstract class BaseExport
{
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
            $value = is_array($column) ? data_get($column, 'name') : $column;
            // Set the column name corresponding to each attribute
            $this->getCell($columnIndex, $this->currentRow)->setValue($value);
            // Increase the value of the column's index
            $columnIndex++;
        }
        // Increase the value of the row's index by 1
        $this->currentRow += 1;
    }

    /**
     * Get cell address
     *
     * @param  mixed $currentCol
     * @param  mixed $currentRow
     * @return Cell
     */
    public function getCell($currentCol, $currentRow): Cell
    {
        return $this->activeWorksheet->getCell([$currentCol, $currentRow]);
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

    /**
     * Find max row number of model
     *
     * @param  Model $model
     * @param  array $relations
     * @return int
     */
    public function maxRawOfModel(Model $model, array $relations): int
    {
        return collect($relations)
            ->filter(fn ($v, $k) => array_uintersect(
                [$model->relationships($k)[0]],
                ['hasMany', 'belongsToMany', 'morphMany', 'morphToMany', 'morphedByMany'],
                'strcasecmp'
            ))
            ->map(fn ($v) => $v->count())
            ->max();
    }
}
