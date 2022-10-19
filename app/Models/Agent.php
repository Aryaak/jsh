<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'identity_number',
        'is_active',
        'is_verified',
        'jamsyar_username',
        'jamsyar_password',
        'branch_id'
    ];
}
