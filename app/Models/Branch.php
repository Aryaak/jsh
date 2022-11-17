<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Branch extends Model
{
    use HasFactory, HasSlug;
    protected $fillable = ['name','slug','is_regional','jamsyar_username','jamsyar_password','regional_id'];
    protected $casts = ['is_regional' => 'boolean'];
    protected $appends = ['jamsyar_password_masked'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    // Accessor

    public function jamsyarPasswordMasked(): Attribute
    {
        return Attribute::make(get: fn() => Str::mask($this->jamsyar_password, "*", 0));
    }

    // Relations

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
