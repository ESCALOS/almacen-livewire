<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function Users(){
        return $this->hasMany(User::class);
    }

    public function Requirements(){
        return $this->hasMany(Requirement::class);
    }

    public function WarehouseDepartments(){
        return $this->hasMany(WarehouseDepartment::class);
    }
}
