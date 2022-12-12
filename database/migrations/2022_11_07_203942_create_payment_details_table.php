<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal('nominal',20,5);
            $table->foreignId('payment_id')->constrained();
            $table->foreignId('surety_bond_id')->nullable()->constrained();
            $table->foreignId('guarantee_bank_id')->nullable()->constrained();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('payment_details');
    }
};
