<?php

namespace Database\Seeders;

use DB;
use App\Models\Obligee;
use Illuminate\Database\Seeder;

class ObligeeSeeder extends Seeder
{
    public function run()
    {
        $params = [
            [
                'name' => 'POKJA PEMBANGUNAN GEDUNG RADIOTERAPI TAHAP II ILP RSUD KABUPATEN SIDOARJO',
                'address' => 'JL. MOJOPAHIT NO. 667 SIDOARJO',
                'type' => '1',
                'city_id' => '1',
                'status' => 'Belum Sinkron',
                'jamsyar_id' => '0',
                'jamsyar_code' => '0'
            ],
            [
                'name' => 'DIREKTUR PERUMDA AIR MINUM DANUM BENUANTA KABUPATEN BULUNGAN',
                'address' => 'JL. RAMBUTAN No. 02 TANJUNG SELOR',
                'type' => '2',
                'city_id' => '1',
                'status' => 'Sinkron',
                'jamsyar_id' => '0',
                'jamsyar_code' => '0'
            ]
        ];
        Obligee::insert($params);
        DB::table('obligees')->update(['created_at' => now(),'updated_at' => now()]);

        // Obligee::jamsyar();
    }
}
