<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','is_regional','jamsyar_username','jamsyar_password','regional_id'];
    protected $casts = ['is_regional' => 'boolean'];
    public function branches(){
        return $this->hasMany(Branch::class,'regional_id');
    }
    public function user(){
        return $this->hasOne(User::class);
    }
    public function regional(){
        return $this->belongsTo(Branch::class,'regional_id');
    }
    private static function fetch(object $args): array{
        $params = [
            'name' => $args->name,
            'is_regional' => $args->is_regional,
            'slug' => Str::slug($args->name),
            'jamsyar_username' => $args->jamsyar_username,
            'jamsyar_password' => $args->jamsyar_password,
        ];
        if($params['is_regional'] == 0){
            $params['regional_id'] = $args->regionalId;
        }
        return $params;
    }
    public static function buat(array $params): self{
        return self::create(self::fetch((object)$params));
    }
    public function ubah(array $params): bool{
        return $this->update(self::fetch((object)$params));
    }
    public function hapus(): bool{
        return $this->delete();
    }
}
