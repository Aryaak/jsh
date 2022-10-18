<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surety_bond_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('surety_bond_id')->constrained();
            $table->foreignId('status_id')->constrained();
            $table->timestamps();
        });
    }
};
