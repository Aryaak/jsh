<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->date('expired_at');
            $table->foreignId('principal_id')->constrained();
            $table->timestamps();
        });
    }
};
