<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    public $fillable = [
        'number',
        'name',
        'agent_id',
        'bank_id'
    ];

    private static function fetch(object $args): array{
        return [
            'number' => $args->number,
            'name' => $args->name,
            'agent_id' => $args->agent_id,
            'bank_id' => $args->bank_id,
        ];
    }

    public function agent(){
        return $this->belongsTo(Agent::class,'agent_id');
    }

    public function bank(){
        return $this->belongsTo(Bank::class,'bank_id');
    }

    public static function buat(array $params, $id): self{
        $bank_account = array(
            'number' => $params['number'],
            'name' => $params['name_bank'],
            'agent_id' => $id,
            'bank_id' => $params['bank_id'],
        );
        return self::create(self::fetch((object)$bank_account));
    }
    public function ubah(array $params, $id): bool{
        $bank_account = array(
            'number' => $params['number'],
            'name' => $params['name_bank'],
            'agent_id' => $id,
            'bank_id' => $params['bank_id'],
        );
        return $this->update(self::fetch((object)$bank_account));
    }
    public function hapus(): bool{
        return $this->delete();
    }
}
