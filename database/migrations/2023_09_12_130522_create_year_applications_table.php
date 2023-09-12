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
        Schema::create('year_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained();
            $table->integer('year');
            $table->foreignId('technical_resource_id')->constrained();
            $table->foreignId('unit_id')->constrained();
            $table->float('quantity', 13, 3);
            $table->float('quantity_m1', 13, 3);
            $table->float('quantity_m2', 13, 3);
            $table->float('quantity_m3', 13, 3);
            $table->float('quantity_m4', 13, 3);
            $table->float('quantity_m5', 13, 3);
            $table->float('quantity_m6', 13, 3);
            $table->float('quantity_m7', 13, 3);
            $table->float('quantity_m8', 13, 3);
            $table->float('quantity_m9', 13, 3);
            $table->float('quantity_m10', 13, 3);
            $table->float('quantity_m11', 13, 3);
            $table->float('quantity_m12', 13, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('year_applications');
    }
};
