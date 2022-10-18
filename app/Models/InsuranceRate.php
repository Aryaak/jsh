<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class InsuranceRate extends Model
{
    use HasFactory;

    public $fillable = ['min_value','rate_value','polish_cost','stamp_cost','desc','insurance_id','insurance_type_id'];
}
