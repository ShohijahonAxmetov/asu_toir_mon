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
        Schema::create('repair_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('tech_map_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('tech_map_tech_operation_id')
                ->nullable()
                ->constrained('tech_operations')
                ->nullOnDelete();
            $table->foreignId('tech_operation_id')
                ->nullable()
                ->constrained();
            $table->integer('duration_hours')->default(0);
            $table->integer('duration_minutes')->default(0);
            $table->text('comments')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_logs');
    }
};
