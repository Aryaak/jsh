<?php

namespace Database\Seeders;

use DB;
Use App\Helpers\Jamsyar;
use App\Models\Principal;
use Illuminate\Database\Seeder;

class PrincipalSeeder extends Seeder
{
    public function run()
    {
        // $params = [
        //     [
        //         'name' => 'AHMAD SUPRIADI',
        //         'phone' => '1233123123',
        //         'email' => 'email@gmail.com',
        //         'address' => 'Jl. Samratulangi No. 10 Bulukumba',
        //         'domicile' => 'Surabaya',
        //         'score' => 7.5,
        //         'npwp_number' => '123',
        //         'npwp_expired_at' => now(),
        //         'nib_number' => '123',
        //         'nib_expired_at' => now(),
        //         'pic_name' => 'AHMAD SUPRIADI',
        //         'pic_position' => 'Direktur',
        //         'jamsyar_id' => '855.163',
        //         'jamsyar_code' => 'kode',
        //         'city_id' => 1,
        //     ]
        // ];
        // Principal::insert($params);
        // DB::table('principals')->update(['created_at' => now(),'updated_at' => now()]);

        $nextOffset = true;
        $offset = 0;
        $dataCount = 0;
        while($nextOffset) {
            $response = Jamsyar::principals([
                "nama_principal"=> "",
                "kode_unik_principal"=> "",
                "limit" => 20,
                "offset" => $offset
            ]);
            Principal::upsert(array_filter(array_map(function($principal){
                \Log::info($principal['nama_principal'].' '.$principal['alamat_principal'].' '.$principal['kode_unik_principal']);
                if($principal['nama_principal'] && $principal['alamat_principal'] && $principal['kode_unik_principal']){
                    return [
                        'name' => $principal['nama_principal'],
                        'address' => $principal['alamat_principal'],
                        'jamsyar_code' => $principal['kode_unik_principal'],
                    ];
                }
            },$response['data'])),['jamsyar_code'],['name','address']);
            DB::table('principals')->update(['created_at' => now(),'updated_at' => now()]);

            if(config('app.env') == 'local'){
                if($dataCount >= 50){
                    $nextOffset = false;
                }else{
                    $dataCount += 20;
                    $offset += 20;
                }
            }else if(config('app.env') == 'production'){
                if($response['total_record'] < 20){
                    $nextOffset = false;
                }else{
                    $dataCount += 20;
                    $offset += 20;
                }
            }
        }
    }
}
