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
        Schema::create('section_scores', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_result_id');
            $table->integer('score')->nullable();
            $table->string('type');
            $table->integer('percent')->nullable();
            $table->integer('section_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_scores');
    }
};
