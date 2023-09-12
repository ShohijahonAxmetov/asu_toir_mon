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
        Schema::create('technical_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_technical_inspection_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->text('who_conducted');
            $table->text('desc');
            $table->date('now');
            $table->date('next');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_inspections');
    }
};
