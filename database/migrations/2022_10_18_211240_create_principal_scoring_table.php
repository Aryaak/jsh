<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('principal_scoring', function (Blueprint $table) {
            $table->foreignId('principal_id')->constrained();
            $table->foreignId('scoring_id')->constrained();
            $table->primary(['principal_id', 'scoring_id']);
            $table->index(['principal_id', 'scoring_id']);
            $table->timestamps();
        });
    }
};
