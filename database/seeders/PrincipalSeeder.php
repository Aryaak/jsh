<?php

namespace Database\Seeders;

use DB;
use App\Models\Principal;
use Illuminate\Database\Seeder;

class PrincipalSeeder extends Seeder
{
    public function run()
    {
        $params = [
            [
                'name' => 'AHMAD SUPRIADI',
                'phone' => '1233123123',
                'email' => 'email@gmail.com',
                'address' => 'Jl. Samratulangi No. 10 Bulukumba',
                'domicile' => 'Surabaya',
                'score' => 7.5,
                'npwp_number' => '123',
                'npwp_expired_at' => now(),
                'nib_number' => '123',
                'nib_expired_at' => now(),
                'pic_name' => 'AHMAD SUPRIADI',
                'pic_position' => 'Direktur',
                'jamsyar_id' => '855.163',
                'jamsyar_code' => 'kode',
                'city_id' => 1,
            ]
        ];
        Principal::insert($params);
        DB::table('principals')->update(['created_at' => now(),'updated_at' => now()]);

    //    Principal::jamsyar();
    }
}
