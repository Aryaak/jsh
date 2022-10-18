<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('name');
            $table->foreignId('agent_id')->constrained();
            $table->foreignId('bank_id')->constrained();
            $table->timestamps();
        });
    }
};
