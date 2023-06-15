<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseDepartment extends Model
{
    use HasFactory;

    protected $fillable = ['warehouse_detail_id','department_id'];

    public function Department(){
        return $this->belongsTo(Department::class);
    }

    public function WarehouseDetail() {
        return $this->belongsTo(WarehouseDetail::class);
    }

    public function WarehouseInputs() {
        return $this->hasMany(WarehouseInput::class);
    }

    public function WarehouseOutputs() {
        return $this->hasMany(WarehouseOutput::class);
    }
}
