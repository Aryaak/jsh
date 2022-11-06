<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surety_bonds', function (Blueprint $table) {
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
            $table->unsignedInteger('service_charge');
            $table->unsignedInteger('admin_charge');
            $table->unsignedBigInteger('total_charge');
            $table->unsignedDecimal('profit',10,2);
            $table->unsignedInteger('insurance_polish_cost');
            $table->unsignedInteger('insurance_stamp_cost');
            $table->unsignedDecimal('insurance_total_net',10,2);
            $table->unsignedInteger('office_polish_cost');
            $table->unsignedInteger('office_stamp_cost');
            $table->unsignedDecimal('office_total_net',10,2);
            $table->foreignId('principal_id')->constrained();
            $table->foreignId('agent_id')->constrained();
            $table->foreignId('obligee_id')->constrained();
            $table->foreignId('insurance_id')->constrained();
            $table->foreignId('insurance_type_id')->constrained();
            $table->unsignedBigInteger('revision_from_id')->nullable();
            $table->float('score');
            $table->timestamps();
            $table->foreign('revision_from_id')->references('id')->on('surety_bonds');
        });
    }
};
