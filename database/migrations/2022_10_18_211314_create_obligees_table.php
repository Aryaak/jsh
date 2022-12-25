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
            $table->mediumText('name');
            $table->text('address');
            $table->string('type')->nullable();
            $table->string('jamsyar_id')->nullable();
            $table->string('jamsyar_code')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('city_id')->nullable()->constrained();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('obligees');
    }
};
