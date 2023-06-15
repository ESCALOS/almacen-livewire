<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

    public function WarehouseDetails(){
        return $this->hasMany(Warehouse::class);
    }

    public function Users(){
        return $this->belongsToMany(User::class);
    }
}
