<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->decimal('nominal',20,2);
            $table->date('transaction_date');

            $table->unsignedBigInteger('regional_id')->nullable();
            $table->foreign('regional_id')->references('id')->on('branches');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
