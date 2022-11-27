<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('instalment_payable', function (Blueprint $table) {
            $table->foreignId('instalment_id')->constrained();
            $table->foreignId('payable_id')->constrained();
            $table->primary(['instalment_id', 'payable_id']);
            $table->index(['instalment_id', 'payable_id']);
            $table->unsignedBigInteger('nominal');
            $table->timestamps();
        });
    }
};
