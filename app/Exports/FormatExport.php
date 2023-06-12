<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FormatExport implements FromCollection,ShouldAutoSize
{
    private $columns;

    public function __construct($columns = array()) {
        $this->columns = $columns;
    }

    public function collection()
    {
        return collect([$this->columns]);
    }
}
