<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\MeasurementUnit;
use App\Models\Product;
use App\Models\WarehouseDetail;
use App\Models\WarehouseInput;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

class WarehouseInputImport implements OnEachRow
{
    private $i = 0;
    private $warehouseId;

    public function __construct($warehouseId)
    {
        $this->warehouseId = $warehouseId;
    }
    public function onRow(Row $row): void
    {
        if($this->i == 0){
            $this->i = 1;
            return;
        }
        if($row[0] != '' && $row[2] != '' && $row[3] != '' && $row[4] != '' && $row[5] != '' && $row[6] != ''){
            DB::transaction(function () use ($row) {
                $category = Category::firstOrCreate(
                    ['name' => strtoupper($row[2])],
                    ['description' => '']
                );

                $measurementUnit = MeasurementUnit::firstOrCreate([
                    'name' => strtoupper($row[3]),
                    'abbreviation' => strtoupper($row[4]),
                ]);

                $product = Product::firstOrCreate(
                    ['name' => strtoupper($row[0])],
                    [
                        'description' => strtoupper($row[1]),
                        'category_id' => $category->id,
                        'measurement_unit_id' => $measurementUnit->id,
                    ]
                );

                $warehouseDetail = WarehouseDetail::firstOrCreate([
                    'warehouse_id' => $this->warehouseId,
                    'product_id' => $product->id
                ]);

                $warehouseInput = new WarehouseInput();
                $warehouseInput->warehouse_detail_id = $warehouseDetail->id;
                $warehouseInput->quantity = $row[5];
                $warehouseInput->price = $row[6];
                $warehouseInput->save();

                //Comentado porque el trigger implementado ya hace esta función
                /*$warehouseDetail->quantity = $warehouseDetail->quantity + $row[5];
                $warehouseDetail->price = $warehouseDetail->price + $row[6];
                $warehouseDetail->save();*/
            });
        }
    }
}
