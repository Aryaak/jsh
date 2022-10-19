<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->boolean('is_regional');
            $table->string('jamsyar_username')->nullable()->comment('only for regional');
            $table->string('jamsyar_password')->nullable()->comment('only for regional');

            $table->unsignedBigInteger('regional_id')->nullable();
            $table->foreign('regional_id')->references('id')->on('branches');
            $table->timestamps();
        });
    }
};
