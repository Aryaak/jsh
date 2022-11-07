<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nominal');
            $table->boolean('is_paid_off')->default(false);
            $table->foreignId('payment_id')->constrained();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('payables');
    }
};
