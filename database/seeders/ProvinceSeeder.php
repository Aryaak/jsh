<?php

namespace Database\Seeders;

use DB;
Use App\Helpers\Sirius;
Use App\Helpers\Jamsyar;
use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        Province::upsert(array_map(function($item){
            return[
                'id' => $item['kode_propinsi'],
                'name' => $item['nama_propinsi']
            ];
        },Jamsyar::provinces()),['id'],['name']);
        DB::table('provinces')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
