<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    public $fillable = ['title','type','text','bank_id'];
    public static function types(){
        return ['kuitansi','surat_permohonan','syarat_bank'];
    }
}
