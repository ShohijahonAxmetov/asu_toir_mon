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
        Schema::create('tech_operation_technical_resource', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tech_operation_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('technical_resource_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->text('characteristics')->nullable();
            $table->float('quantity', 9, 3);
            $table->foreignId('unit_id')
                ->constrained()
                ->nullOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tech_operation_technical_resource');
    }
};
