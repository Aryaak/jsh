<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Agent;
use App\Models\Insurance;
use App\Models\InsuranceType;
use App\Models\Obligee;
use App\Models\Principal;
use App\Models\GuaranteeBank;
use Illuminate\Database\Seeder;

class GuaranteeBankSeeder extends Seeder
{
    public function run()
    {
        for ($i=1; $i < 150; $i++) {
            GuaranteeBank::buat([
                "receiptNumber" => "111".$i,
                "bondNumber" => "112".$i,
                "polishNumber" => "113".$i,
                "agentId" => Agent::inRandomOrder()->first()->id,
                "bankId" => Bank::inRandomOrder()->first()->id,
                "insuranceId" => Insurance::inRandomOrder()->first()->id,
                "insuranceTypeId" => InsuranceType::inRandomOrder()->first()->id,
                "obligeeId" => Obligee::inRandomOrder()->first()->id,
                "principalId" => Principal::inRandomOrder()->first()->id,
                "serviceCharge" => mt_rand(15000000,500000000),
                "adminCharge" =>  mt_rand(15000,50000),
                "contractValue" => mt_rand(15000000,500000000),
                "insuranceValue" => mt_rand(15000000,50000000),
                "startDate" => date('Y-m-d',strtotime("+ $i days")),
                "endDate" => date('Y-m-d',strtotime("+ ".(30+$i)." days")),
                "dueDayTolerance" => mt_rand(0,2),
                "dayCount" => mt_rand(30,150),
                "projectName" => "Project Seeder $i",
                "documentTitle" => "Document Title Seeder $i",
                "documentNumber" => "Document Number Seeder $i",
                "documentExpiredAt" => date('Y-m-d',strtotime("+ ".(30+$i)." days")),
                "scoring" => [
                  9 => "2",
                  10 => "5",
                  11 => "8",
                  12 => "10",
                  13 => "14",
                  14 => "18",
                  15 => "21",
                  16 => "24",
                  17 => "26",
                  18 => "30",
                  19 => "32",
                  20 => "34",
                  21 => "38",
                  22 => "42",
                  23 => "44",
                  24 => "47",
                  25 => "50",
                ]
            ]);
        }
    }
}
