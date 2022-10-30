<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class GuaranteeBankStatus extends Model
{
    use HasFactory;

    public $fillable = ['type','guarantee_bank_id','status_id'];
    public function guarantee_bank(){
        return $this->belongsTo(GuaranteeBank::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
    public static function types(){
        return Status::types();
    }
}
