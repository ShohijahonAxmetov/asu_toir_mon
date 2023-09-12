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
        Schema::create('remont_moves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_remont_id')->constrained();
            $table->date('remont_begin');
            $table->date('remont_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remont_moves');
    }
};
