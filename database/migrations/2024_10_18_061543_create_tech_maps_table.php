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
        Schema::create('tech_maps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tech_map_group_id')
                ->constrained()
                ->nullOnUpdate();
            $table->text('title');
            $table->date('agreed_at')->nullable();
            $table->string('code');
            $table->integer('hours')->comment('Продолжительность, часы');
            $table->integer('minutes')->comment('Продолжительность, минуты');
            $table->mediumText('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tech_maps');
    }
};
