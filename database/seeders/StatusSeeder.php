<?php

namespace Database\Seeders;

use DB;
use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $params = [
            ['name' => 'input','type' => 'process','for_process' => 'surety_bond'],
            ['name' => 'analisa asuransi','type' => 'process','for_process' => 'surety_bond'],
            ['name' => 'terbit','type' => 'process','for_process' => 'surety_bond'],
            ['name' => 'input','type' => 'process','for_process' => 'guarantee_bank'],
            ['name' => 'analisa asuransi','type' => 'process','for_process' => 'guarantee_bank'],
            ['name' => 'analisa bank','type' => 'process','for_process' => 'guarantee_bank'],
            ['name' => 'terbit','type' => 'process','for_process' => 'guarantee_bank'],
            ['name' => 'terbit','type' => 'insurance','for_process' => null],
            ['name' => 'batal','type' => 'insurance','for_process' => null],
            ['name' => 'revisi','type' => 'insurance','for_process' => null],
            ['name' => 'salah cetak','type' => 'insurance','for_process' => null],
            ['name' => 'lunas','type' => 'finance','for_process' => null],
            ['name' => 'belum lunas','type' => 'finance','for_process' => null]
        ];
        Status::insert($params);
        DB::table('statuses')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
