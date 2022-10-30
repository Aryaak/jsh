<?php

namespace Database\Seeders;

use DB;
use App\Models\Insurance;
use Illuminate\Database\Seeder;

class InsuranceSeeder extends Seeder
{
    public function run()
    {
        $params = [
            ['name' => 'PERSEROAN TERBATAS JAMKRINDO SYARIAH','alias' => 'Jamsyar SBY','address' => 'Kantor Cabang Surabaya, JL. Bogowonto No. 51 Surabaya 60241','pc_name' => 'BAMBANG HENDRAMAN','pc_position' => 'KEPALA CABANG'],
            ['name' => 'PT JAMKRIDA','alias' => 'Jamkrida','address' => 'Surabaya','pc_name' => '-','pc_position' => '-'],
            ['name' => 'PT. ASURANSI BERDIKARI SURABAYA','alias' => 'Berdikari SBY','address' => 'JL. PERAK BARAT NO. 91 SURABAYA','pc_name' => 'Ir. DONO WIDADI','pc_position' => 'Kepala Cabang surabaya'],
            ['name' => 'PT. ASURANSI RAMA SATRIA WIBAWA','alias' => 'Rama SBY','address' => 'JL. MH. THAMRIN NO. 14 SURABAYA Telp. (031) 5632954, 5676888 Fax : (031) 5672081','pc_name' => 'BUDI HENDRO TJAHJONO, ST.AAAI-K','pc_position' => 'KEPALA CABANG'],
            ['name' => 'PT. ASURANSI RAMA SATRIA WIBAWA MALANG','alias' => 'Rama MLG','address' => 'Surabaya','pc_name' => '-','pc_position' => '-'],
            ['name' => 'PT. ASURANSI RECAPITAL','alias' => 'Recapital','address' => 'Surabaya','pc_name' => '-','pc_position' => '-'],
            ['name' => 'PT. PENJAMINAN JAMKRINDO SYARIAH JAKARTA','alias' => 'Jamsyar JKT','address' => 'Jakarta','pc_name' => '-','pc_position' => '-'],
        ];
        Insurance::insert($params);
        DB::table('insurances')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
