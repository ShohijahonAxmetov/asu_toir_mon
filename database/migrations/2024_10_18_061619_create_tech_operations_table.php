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
        Schema::create('tech_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tech_operation_stage_id')
                ->constained()
                ->nullOnUpdate();
            $table->text('title');
            $table->text('full_title')->nullable();
            $table->integer('hours')->comment('Продолжительность, часы');
            $table->integer('minutes')->comment('Продолжительность, минуты');
            $table->bigInteger('amount')->nullable()->comment('Расценка, в сумах');
            $table->mediumText('content')->nullable()->comment('Содержание работ');
            $table->mediumText('comments')->nullable()->comment('Комментарии');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tech_operations');
    }
};
