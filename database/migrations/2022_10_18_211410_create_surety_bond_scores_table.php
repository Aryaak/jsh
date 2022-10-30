<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surety_bond_scores', function (Blueprint $table) {
            $table->id();
            $table->float('value');
            $table->string('category');
            $table->foreignId('surety_bond_id')->constrained();
            $table->foreignId('scoring_id')->constrained();
            $table->foreignId('scoring_detail_id')->constrained();
            $table->timestamps();
        });
    }
};
