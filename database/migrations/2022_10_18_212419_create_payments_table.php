<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal('total_bill',20,5);
            $table->timestamp('paid_at');
            $table->integer('month')->comment('ex. 01..09..12');
            $table->year('year');
            $table->string('type');
            $table->text('desc')->nullable();
            $table->foreignId('agent_id')->nullable()->constrained();
            $table->foreignId('insurance_id')->nullable()->constrained();
            $table->foreignId('principal_id')->nullable()->constrained();
            $table->foreignId('branch_id')->nullable()->constrained();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
