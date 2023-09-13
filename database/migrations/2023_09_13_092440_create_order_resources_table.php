<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained();
            $table->string('order_number');
            $table->date('order_date');
            $table->float('order_quantity', 13, 3);
            $table->string('contract_number')->nullable();
            $table->date('contract_date')->nullable();
            $table->integer('local_foreign')->nullable();
            $table->date('date_manufacture_contract')->nullable();
            $table->date('date_manufacture_fact')->nullable();
            $table->date('customs_date_receipt')->nullable();
            $table->date('customs_date_exit')->nullable();
            $table->date('date_delivery_object')->nullable();
            $table->foreignId('execution_statuse_id')->constrained()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_resources');
    }
};
