<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('total_bill');
            $table->unsignedBigInteger('paid_bill');
            $table->unsignedBigInteger('unpaid_bill');
            $table->foreignId('payment_period_id')->constrained();
            $table->string('type');
            $table->timestamps();
        });
    }
};
