<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('scorings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable()->comment('only for surety bond and guarantee bank');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('scorings');
    }
};
