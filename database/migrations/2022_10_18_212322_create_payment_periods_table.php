<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('month')->comment('ex. 01..09..12');
            $table->year('year');
            $table->timestamps();
        });
    }
};
