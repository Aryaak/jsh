<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class GuaranteeBankScore extends Model
{
    use HasFactory;

    public $fillable = ['value','guarantee_bank_id','scoring_id','scoring_detail_id'];
}
