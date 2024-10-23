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
        Schema::create('tech_map_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tech_map_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('model');
            $table->bigInteger('model_id');
            $table->integer('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tech_map_operations');
    }
};
