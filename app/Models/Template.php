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

    private static function fetch(object $args): array{
        return [
            'title' => $args->title,
            'type' => $args->type,
            'text' => $args->text,
            'bank_id' => $args->bank_id,
        ];
    }

    public function bank_accounts(){
        return $this->hasMany(BankAccount::class);
    }
    public function bank_rates(){
        return $this->hasMany(BankRate::class);
    }
    public static function buat(array $params, $id): self{
        $data = null;
        for($i = 0; $i < count($params['title']); $i++){
            $template = array(
                'title' => $params['title'][$i],
                'type' => $params['type'][$i],
                'text' => "<p><i>TESTING</i></p>",
                'bank_id' => $id
            );
            $data = self::create(self::fetch((object)$template));
        }
        return $data;
    }
    public function ubah(array $params, $id_bank, $id): bool{
        $template = array(
            'title' => $params['title'][$id_bank],
            'type' => $params['type'][$id_bank],
            'text' => "<p><i>TESTING</i></p>",
            'bank_id' => $id
        );
        return $this->update(self::fetch((object)$template));
    }
    public function hapus(): bool{
        return $this->delete();
    }
}
