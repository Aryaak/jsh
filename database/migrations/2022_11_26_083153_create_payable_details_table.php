<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payable_details', function (Blueprint $table) {
            $table->id();
            $table->decimal('nominal',20,5);
            $table->foreignId('payable_id')->constrained();
            $table->foreignId('surety_bond_id')->nullable()->constrained();
            $table->foreignId('guarantee_bank_id')->nullable()->constrained();
            $table->timestamps();
        });
    }
};
