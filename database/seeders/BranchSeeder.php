<?php

namespace Database\Seeders;

use DB;
use Str;
use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $params = [
            ['name' => 'Jawa Timur','slug' => Str::slug('Jawa Timur'),'is_regional' => 1,'jamsyar_username' => 'jatim','jamsyar_password' => 'jatim','regional_id' => null],
            ['name' => 'Surabaya','slug' => Str::slug('Surabaya'),'is_regional' => 0,'jamsyar_username' => null,'jamsyar_password' => null,'regional_id' => 1],
            ['name' => 'Gresik','slug' => Str::slug('Gresik'),'is_regional' => 0,'jamsyar_username' => null,'jamsyar_password' => null,'regional_id' => 1],
            ['name' => 'Malang','slug' => Str::slug('Malang'),'is_regional' => 0,'jamsyar_username' => null,'jamsyar_password' => null,'regional_id' => 1],
            ['name' => 'Madiun','slug' => Str::slug('Madiun'),'is_regional' => 0,'jamsyar_username' => null,'jamsyar_password' => null,'regional_id' => 1],
            ['name' => 'Kediri','slug' => Str::slug('Kediri'),'is_regional' => 0,'jamsyar_username' => null,'jamsyar_password' => null,'regional_id' => 1],
        ];
        Branch::insert($params);
        DB::table('branches')->update(['created_at' => now(),'updated_at' => now()]);
    }
}
