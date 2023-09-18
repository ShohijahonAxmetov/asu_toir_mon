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
        Schema::table('type_equipments', function (Blueprint $table) {
            $table->foreignId('vid_equipment_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_equipments', function (Blueprint $table) {
            $table->dropColumn('vid_equipment_id');
        });
    }
};
