<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'description',
        'nominal',
        'transaction_date',
        'regional_id',
    ];

    private static function fetch(object $args): array{
        return [
            'title' => $args->title,
            'description' => $args->description,
            'nominal' => $args->nominal,
            'transaction_date' => $args->transaction_date,
            'regional_id' => $args->regional_id,
        ];
    }

    public static function buat(array $params): self{
        $agent = array(
            'title' => $params['title'],
            'description' => $params['description'],
            'nominal' => $params['nominal'],
            'transaction_date' => $params['transaction_date'],
            'regional_id' => $params['regional_id'],
        );
        return self::create(self::fetch((object)$agent));
    }
    public function ubah(array $params): bool{
        $agent = array(
            'title' => $params['title'],
            'description' => $params['description'],
            'nominal' => $params['nominal'],
            'transaction_date' => $params['transaction_date'],
            'regional_id' => $params['regional_id'],
        );
        return $this->update(self::fetch((object)$agent));
    }
    public function hapus(): bool{
        return $this->delete();
    }
}
