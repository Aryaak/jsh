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
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('domicile')->nullable();
            $table->float('score')->nullable();
            $table->string('npwp_number')->nullable();
            $table->date('npwp_expired_at')->nullable();
            $table->string('nib_number')->nullable();
            $table->date('nib_expired_at')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_position')->nullable();
            $table->string('jamsyar_id')->nullable();
            $table->string('jamsyar_code')->nullable();
            $table->foreignId('city_id')->nullable()->constrained();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('principals');
    }
};
