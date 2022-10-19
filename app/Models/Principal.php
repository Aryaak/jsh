<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Principal extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'domicile',
        'score',
        'npwp_number',
        'npwp_expired_at',
        'nib_number',
        'nib_expired_at',
        'pic_name',
        'pic_position',
        'jamsyar_id',
        'jamsyar_code',
        'city_id',
    ];
}
