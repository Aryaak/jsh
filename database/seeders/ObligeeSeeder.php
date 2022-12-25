<?php

namespace Database\Seeders;

use DB;
use App\Models\Obligee;
Use App\Helpers\Jamsyar;
use Illuminate\Database\Seeder;

class ObligeeSeeder extends Seeder
{
    public function run()
    {
        // $params = [
        //     [
        //         'name' => 'POKJA PEMBANGUNAN GEDUNG RADIOTERAPI TAHAP II ILP RSUD KABUPATEN SIDOARJO',
        //         'address' => 'JL. MOJOPAHIT NO. 667 SIDOARJO',
        //         'type' => '-',
        //         'city_id' => '1',
        //         'status' => '-',
        //         'jamsyar_id' => '0',
        //         'jamsyar_code' => '0'
        //     ],
        //     [
        //         'name' => 'DIREKTUR PERUMDA AIR MINUM DANUM BENUANTA KABUPATEN BULUNGAN',
        //         'address' => 'JL. RAMBUTAN No. 02 TANJUNG SELOR',
        //         'type' => '-',
        //         'city_id' => '1',
        //         'status' => '-',
        //         'jamsyar_id' => '0',
        //         'jamsyar_code' => '0'
        //     ]
        // ];
        // Obligee::insert($params);
        // DB::table('obligees')->update(['created_at' => now(),'updated_at' => now()]);

        $nextOffset = true;
        $offset = 0;
        $dataCount = 0;
        while($nextOffset) {
            $response = Jamsyar::obligees([
                "nama_obligee"=> "",
                "kode_unik_obligee"=> "",
                "limit" => 20,
                "offset" => $offset
            ]);
            Obligee::upsert(array_filter(array_map(function($obligee){
                if($obligee['nama_obligee'] && $obligee['alamat_obligee'] && $obligee['kode_unik_obligee']){
                    \Log::info($obligee['nama_obligee'].' '.$obligee['alamat_obligee'].' '.$obligee['kode_unik_obligee']);
                    return [
                        'name' => $obligee['nama_obligee'],
                        'address' => $obligee['alamat_obligee'],
                        'jamsyar_code' => $obligee['kode_unik_obligee'],
                        'status' => 'Sinkron'
                    ];
                }
            },$response['data'])),['jamsyar_code'],['name','address']);
            DB::table('obligees')->update(['created_at' => now(),'updated_at' => now()]);

            if(config('app.env') == 'local'){
                if($dataCount >= 1000){
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
