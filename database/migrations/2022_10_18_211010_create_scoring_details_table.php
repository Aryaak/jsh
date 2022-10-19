<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('scoring_details', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->integer('value');
            $table->foreignId('scoring_id')->constrained();
            $table->timestamps();
        });
    }
};
