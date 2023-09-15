<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('technical_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable()->constrained();
            $table->string('catalog_name');
            $table->string('catalog_number');
            $table->string('nomen_name');
            $table->string('nomen_number');
            $table->integer('time_complete_order');
            $table->integer('delivery_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('technical_resources');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
