<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payable_payment', function (Blueprint $table) {
            $table->foreignId('payable_id')->constrained();
            $table->foreignId('payment_id')->constrained();
            $table->primary(['payable_id', 'payment_id']);
            $table->index(['payable_id', 'payment_id']);
            $table->unsignedBigInteger('nominal');
            $table->timestamps();
        });
    }
};
