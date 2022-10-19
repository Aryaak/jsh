<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->text('address');
            $table->string('identity_number');
            $table->boolean('is_active');
            $table->boolean('is_verified');
            $table->string('jamsyar_username');
            $table->string('jamsyar_password');
            $table->foreignId('branch_id')->constrained();
            $table->timestamps();
        });
    }
};
