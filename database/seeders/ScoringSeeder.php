<?php

namespace Database\Seeders;

use App\Models\Scoring;
use Illuminate\Database\Seeder;

class ScoringSeeder extends Seeder
{
    public function run()
    {
        $params = [
            (object)['scoring' => ['title' => 'Profil Perusahaan (compro)','category' => null],'details' => []],
            (object)['scoring' => ['title' => 'Akta Pendirian','category' => null],'details' => []],
            (object)['scoring' => ['title' => 'Ktp Direktur','category' => null],'details' => []],
            (object)['scoring' => ['title' => 'NIB','category' => null],'details' => []],
            (object)['scoring' => ['title' => 'NPWP','category' => null],'details' => []],
            (object)['scoring' => ['title' => 'SK Domisili Perusahaan','category' => null],'details' => []],
            (object)['scoring' => ['title' => 'Laporan Keuangan 2 Tahun Terakhir','category' => null],'details' => []],
            (object)['scoring' => ['title' => 'Pengalaman Pekerjaan','category' => null],'details' => []],

            (object)['scoring' => ['title' => 'Lama Operasional Usaha', 'category' => 'Character'],'details' => [
                ['text' => '> 5 thn','value' => 1],
                ['text' => '=> 3 thn s/d <= 5 thn','value' => 2],
                ['text' => '< 3 thn','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Hubungan Dengan Obligee', 'category' => 'Character'],'details' => [
                ['text' => 'Sangat Baik','value' => 1],
                ['text' => 'Baik','value' => 2],
                ['text' => 'Cukup','value' => 3]
             ]],

            (object)['scoring' => ['title' => 'Pengalaman Terhadap Jenis Pekerjaan', 'category' => 'Capacity'],'details' => [
                ['text' => '> 4 Proyek yang sama','value' => 1],
                ['text' => '>1 < 4 Proyek yang sama','value' => 2],
                ['text' => 'Belum pernah','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Tenaga Ahli Sesuai Proyek', 'category' => 'Capacity'],'details' => [
                ['text' => '> 5 Tenaga Ahli','value' => 1],
                ['text' => '> 2 < 5 Tenaga Ahli','value' => 2],
                ['text' => '1 Tenaga Ahli','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Peralatan Mengejakan Proyek', 'category' => 'Capacity'],'details' => [
                ['text' => 'Cukup, Milik Sendiri','value' => 1],
                ['text' => 'Sewa Rutin dengan Supplier','value' => 2],
                ['text' => 'Rencana Sewa','value' => 3]
             ]],

            (object)['scoring' => ['title' => 'Rasio Likuiditas', 'category' => 'Capital'],'details' => [
                ['text' => '> 1','value' => 1],
                ['text' => '= 1','value' => 2],
                ['text' => '< 1','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Rasio Profitabilitas', 'category' => 'Capital'],'details' => [
                ['text' => '> 20%','value' => 1],
                ['text' => '= 10 - 20%','value' => 2],
                ['text' => '< 10%','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Rasio Solvabilitas', 'category' => 'Capital'],'details' => [
                ['text' => '> 1','value' => 1],
                ['text' => '= 1','value' => 2],
                ['text' => '< 1','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Audit Laporan Keuangan', 'category' => 'Capital'],'details' => [
                ['text' => 'Auditor Terdaftar','value' => 1],
                ['text' => 'Auditor Intern','value' => 2],
                ['text' => 'Non Audit','value' => 3]
             ]],

            (object)['scoring' => ['title' => 'Syarat Dalam Kontrak', 'category' => 'Condition'],'details' => [
                ['text' => 'Mudah dikerjakan','value' => 1],
                ['text' => 'Masih dapat dikerjakan','value' => 2],
                ['text' => 'Sulit dikerjakan','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Periode Kontrak Proyek', 'category' => 'Condition'],'details' => [
                ['text' => '< 1 Tahun','value' => 1],
                ['text' => 's/d 1 Tahun','value' => 2],
                ['text' => '> 1 Tahun','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Lokasi proyek Terhadap Kantor Pusat', 'category' => 'Condition'],'details' => [
                ['text' => 'Propinsi yang sama','value' => 1],
                ['text' => 'Propinsi Lain','value' => 2],
                ['text' => 'Luar Negeri','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Supply Bahan Baku Proyek', 'category' => 'Condition'],'details' => [
                ['text' => 'dari Propinsi Sendiri','value' => 1],
                ['text' => 'dari Propinsi Terdekat','value' => 2],
                ['text' => 'dari Propinsi Lain','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Bentuk Collateral', 'category' => 'Collateral'],'details' => [
                ['text' => 'Cash Collateral','value' => 1],
                ['text' => 'Assets Collateral','value' => 2],
                ['text' => 'Non Collateral','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Nilai Collateral', 'category' => 'Collateral'],'details' => [
                ['text' => '< 50% Penal Sum','value' => 1],
                ['text' => '> 25% < 50%','value' => 2],
                ['text' => 's/d 10%','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'indemnity Agreement', 'category' => 'Collateral'],'details' => [
                ['text' => 'Sign By Dir dan PS','value' => 1],
                ['text' => 'Sign By Dir dan Kom','value' => 2],
                ['text' => 'Sign By Direktur','value' => 3]
             ]],
            (object)['scoring' => ['title' => 'Legalitas Ind. Agreement', 'category' => 'Collateral'],'details' => [
                ['text' => 'Dibuat Notaris','value' => 1],
                ['text' => 'Didaftarkan ke Notaris','value' => 2],
                ['text' => 'Tanpa Notaris','value' => 3]
             ]],
        ];
        foreach ($params as $param) {
            $scoring = Scoring::create($param->scoring);
            if(!empty($param->details)) $scoring->details()->createMany($param->details);
        }
    }
}
