<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surety_bonds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};