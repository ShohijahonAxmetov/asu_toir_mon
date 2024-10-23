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
        Schema::create('security_measures', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->mediumText('desc');
            $table->foreignId('tech_map_id')
                ->nullable()
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
        Schema::dropIfExists('security_measures');
    }
};
