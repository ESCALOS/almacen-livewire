<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\MeasurementUnit;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

class ProductImport implements OnEachRow
{
    private $i = 0;

    public function onRow(Row $row)
    {
        if($this->i == 0){
            $this->i = 1;
            return;
        }
        if($row[0] != '' && $row[2] != '' && $row[3] != '' && $row[4] != ''){
            $category = Category::firstOrCreate(
                ['name' => strtoupper($row[2])],
                ['description' => '']
            );

            $measurementUnit = MeasurementUnit::firstOrCreate([
                'name' => strtoupper($row[3]),
                'abbreviation' => strtoupper($row[4]),
            ]);

            Product::firstOrCreate(
                ['name' => strtoupper($row[0])],
                [
                    'description' => strtoupper($row[1]),
                    'category_id' => $category->id,
                    'measurement_unit_id' => $measurementUnit->id,
                ]
            );
        }
    }
}
