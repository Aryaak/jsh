<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Status;

class SuretyBondScore extends Model
{
    use HasFactory;

    public $fillable = ['value','surety_bond_id','scoring_id','scoring_detail_id'];
}
