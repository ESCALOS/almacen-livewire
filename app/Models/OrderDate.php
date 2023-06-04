<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDate extends Model
{
    use HasFactory;

    public function Requirements(){
        return $this->hasMany(Requirement::class);
    }

    public function RequirementsSummaries(){
        return $this->hasMany(RequirementSummary::class);
    }
}
