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
        Schema::create('qualification_tech_operation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qualification_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('tech_operation_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->text('characteristics')->nullable();
            $table->integer('count');
            $table->integer('hours')->comment('Продолжительность, часы');
            $table->integer('minutes')->comment('Продолжительность, минуты');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualification_tech_operation');
    }
};
