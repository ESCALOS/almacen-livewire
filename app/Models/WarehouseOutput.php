<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseOutput extends Model
{
    use HasFactory;

    public function WarehouseDetail(){
        return $this->belongsTo(WarehouseDetail::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Reason(){
        return $this->belongsTo(Reason::class);
    }
}
