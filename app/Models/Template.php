<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    public $fillable = ['title','text','bank_id'];
    public static function types(){
        return ['kuitansi','surat_permohonan','syarat_bank'];
    }

    private static function fetch(object $args): array{
        return [
            'title' => $args->title,
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
        $data = Template::first();
        for($i = 0; $i < count($params['title']); $i++){
            if(isset($params['id'][$i]) == false){
                $template = array(
                    'title' => $params['title'][$i],
                    'text' => $params['text'][$i],
                    'bank_id' => $id
                );
                $data = self::create(self::fetch((object)$template));
            }
        }
        return $data;
    }

    public static function buatTemplate(array $params, $id): self{
        $template = array(
            'title' => $params['title'],
            'text' => $params['text'],
            'bank_id' => $id
        );
        return self::create(self::fetch((object)$template));
    }

    public function ubah_bank(array $params, $id_bank, $id): bool{
        $template = array(
            'title' => $params['title'][$id_bank],
            'text' => $params['text'][$id_bank],
            'bank_id' => $id
        );
        return $this->update(self::fetch((object)$template));
    }

    public function ubah(array $params): bool{
        $template = array(
            'title' => $params['title'],
            'text' => $params['text'],
            'bank_id' => $this->bank_id
        );
        return $this->update(self::fetch((object)$template));
    }

    public function hapus(): bool{
        return $this->delete();
    }
}
