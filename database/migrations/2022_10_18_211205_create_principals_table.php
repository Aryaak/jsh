<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('principals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->text('address');
            $table->string('domicile');
            $table->float('score');
            $table->string('npwp_number');
            $table->date('npwp_expired_at');
            $table->string('nib_number');
            $table->date('nib_expired_at');
            $table->string('pic_name');
            $table->string('pic_position');
            $table->string('jamsyar_id');
            $table->string('jamsyar_code');
            $table->foreignId('city_id')->constrained();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('principals');
    }
};
