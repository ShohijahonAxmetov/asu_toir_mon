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
        Schema::create('security_measure_tech_map', function (Blueprint $table) {
            $table->id();
            $table->foreignId('security_measure_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('tech_map_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_measure_tech_map');
    }
};
