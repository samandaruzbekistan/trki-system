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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('score')->nullable();
            $table->integer('percent')->nullable();
            $table->integer('quiz_score')->nullable();
            $table->integer('quiz_percent')->nullable();
            $table->integer('reading_score')->nullable();
            $table->integer('reading_percent')->nullable();
            $table->integer('listening_score')->nullable();
            $table->integer('listening_percent')->nullable();
            $table->integer('writing_score')->nullable();
            $table->integer('writing_percent')->nullable();
            $table->integer('speaking_score')->nullable();
            $table->integer('speaking_percent')->nullable();
            $table->string('level')->nullable();
            $table->string('status')->default('preparing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
