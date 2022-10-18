<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    public $fillable = ['name','alias','address','pc_name','pc_position'];
}
