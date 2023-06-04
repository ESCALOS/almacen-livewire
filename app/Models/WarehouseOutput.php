<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseOutput extends Model
{
    use HasFactory;

    public function WarehouseDepartment(){
        return $this->belongsTo(WarehouseDepartment::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
