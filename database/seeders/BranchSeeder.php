<?php

namespace Database\Seeders;

use DB;
use Str;
use App\Models\Branch;
use App\Models\User;
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
        foreach ($params as $param) {
            $data = Branch::create($param);
            $data->user()->create([
                'name' => $param['name'],
                'username' => $param['slug'],
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
                'role' => $data->is_regional ? 'regional' : 'branch'
            ]);
        }
        User::create([
            'name' => 'Root',
            'username' => 'root',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'role' => 'main',
        ]);
    }
}
