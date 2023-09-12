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
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('type_technical_inspection_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->text('name');
            $table->text('desc')->nullable();
            $table->date('planned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details');
    }
};
