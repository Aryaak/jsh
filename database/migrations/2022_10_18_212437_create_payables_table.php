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
            $table->integer('month');
            $table->year('year');
            $table->unsignedBigInteger('payable_total');
            $table->unsignedBigInteger('paid_total');
            $table->unsignedBigInteger('unpaid_total');
            $table->boolean('is_paid_off')->default(false);
            $table->foreignId('branch_id')->constrained();
            $table->unsignedBigInteger('regional_id');

            $table->timestamps();
            $table->foreign('regional_id')->references('id')->on('branches');
        });
    }
    public function down()
    {
        Schema::dropIfExists('payables');
    }
};
