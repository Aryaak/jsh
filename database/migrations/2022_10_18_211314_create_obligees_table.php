<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('obligees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('type');
            $table->string('jamsyar_id');
            $table->string('jamsyar_code');
            $table->string('status');

            $table->foreignId('city_id')->constrained();
            $table->timestamps();
        });
    }
};
