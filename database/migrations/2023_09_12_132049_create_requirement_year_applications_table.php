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
        Schema::create('requirement_year_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained();
            $table->foreignId('technical_resource_id')->constrained();
            $table->integer('month');
            $table->foreignId('plan_remont_id')->constrained();
            $table->float('required_quantity', 13, 3);
            $table->date('warehouse_date')->nullable();
            $table->float('warehouse_quantity', 13, 3)->nullable();
            $table->float('declared_quantity', 13, 3);
            $table->date('delivery_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirement_year_applications');
    }
};
