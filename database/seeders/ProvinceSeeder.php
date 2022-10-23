<?php

namespace Database\Seeders;

use DB;
Use App\Helpers\Sirius;
use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        $params = [];
        foreach (Sirius::getAllProvince() as $province) {
            $params[] = ['name' => $province]    ;
        }
        Province::insert($params);
        DB::table('provinces')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
