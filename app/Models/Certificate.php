<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    public $fillable = ['number','expired_at','principal_id'];
    public function principal(){
        return $this->belongsTo(Principal::class);
    }
}
