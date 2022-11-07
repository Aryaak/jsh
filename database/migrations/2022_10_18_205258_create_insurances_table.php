<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->text('address');
            $table->string('pc_name');
            $table->string('pc_position');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('insurances');
    }
};
