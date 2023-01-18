<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
    ];

    private static function fetch(object $args): array{
        return [
            'name' => $args->name,
        ];
    }
    public function agent_rates(){
        return $this->hasMany(AgentRate::class);
    }
    public function bank_accounts(){
        return $this->hasMany(BankAccount::class);
    }
    public function bank_rates(){
        return $this->hasMany(BankRate::class);
    }
    public function templates(){
        return $this->hasMany(Template::class);
    }
    public static function buat(array $params): self{
        return self::create(self::fetch((object)$params));
    }
    public function ubah(array $params): bool{
        return $this->update(self::fetch((object)$params));
    }
    public function hapus(): bool{
        try {
            $this->templates->each(function($template) {
                $template->delete();
            });
            return $this->delete();
        } catch (Exception $ex) {
            throw new Exception("Data ini tidak dapat dihapus karena sedang digunakan di data lain!", 422);
        }
    }
}
