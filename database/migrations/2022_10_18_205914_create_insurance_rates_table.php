<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('insurance_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('min_value');
            $table->double('rate_value', 8, 3);
            $table->unsignedInteger('polish_cost');
            $table->unsignedInteger('stamp_cost');
            $table->string('desc')->nullable();
            $table->foreignId('insurance_id')->constrained();
            $table->foreignId('insurance_type_id')->constrained();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('insurance_rates');
    }
};
