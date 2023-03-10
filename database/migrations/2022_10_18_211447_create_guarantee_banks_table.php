<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('guarantee_banks', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number');
            $table->string('bond_number')->nullable();
            $table->string('polish_number')->nullable();
            $table->string('project_name')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('day_count');
            $table->integer('due_day_tolerance');
            $table->string('document_number');
            $table->string('document_title');
            $table->date('document_expired_at');
            $table->unsignedBigInteger('contract_value');
            $table->unsignedBigInteger('insurance_value');
            $table->unsignedInteger('service_charge')->nullable();
            $table->unsignedInteger('admin_charge')->nullable();
            $table->unsignedBigInteger('total_charge')->nullable();
            $table->decimal('profit',20,5);
            $table->unsignedInteger('insurance_polish_cost');
            $table->unsignedInteger('insurance_stamp_cost');
            $table->unsignedDecimal('insurance_rate', 8, 3);
            $table->unsignedDecimal('insurance_net',10,2);
            $table->unsignedDecimal('insurance_net_total',10,2);
            $table->unsignedInteger('office_polish_cost');
            $table->unsignedInteger('office_stamp_cost');
            $table->unsignedDecimal('office_rate', 8, 3);
            $table->unsignedDecimal('office_net',10,2);
            $table->unsignedDecimal('office_net_total',10,2);
            $table->foreignId('bank_id')->constrained();
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('principal_id')->constrained();
            $table->foreignId('agent_id')->constrained();
            $table->foreignId('obligee_id')->constrained();
            $table->foreignId('insurance_id')->constrained();
            $table->foreignId('insurance_type_id')->constrained();
            $table->unsignedBigInteger('revision_from_id')->nullable();
            $table->float('score')->nullable();
            $table->timestamps();
            $table->foreign('revision_from_id')->references('id')->on('guarantee_banks');
        });
    }
    public function down()
    {
        Schema::dropIfExists('guarantee_banks');
    }
};
