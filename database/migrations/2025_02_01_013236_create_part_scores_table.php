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
        Schema::create('part_scores', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_result_id');
            $table->integer('score');
            $table->integer('percent');
            $table->integer('part_id');
            $table->integer('section_score_id');
            $table->string('status')->default('checked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_scores');
    }
};
