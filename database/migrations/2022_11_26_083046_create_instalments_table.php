<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('instalments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nominal');
            $table->dateTime('paid_at');
            $table->text('desc')->nullable();
            $table->foreignId('branch_id')->constrained();
            $table->unsignedBigInteger('regional_id')->nullable();
            $table->timestamps();
            $table->foreign('regional_id')->references('id')->on('branches');
        });
    }
};
