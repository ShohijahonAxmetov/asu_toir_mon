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
        Schema::create('technical_resource_type_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_equipment_id')->constrained();
            $table->foreignId('technical_resource_id')->constrained();
            $table->bigInteger('parent_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_resource_type_equipment');
    }
};
