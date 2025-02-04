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
        Schema::create('exam_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('exam_levels')->insert([
            ['name' => 'A1'],
            ['name' => 'A2'],
            ['name' => 'B1'],
            ['name' => 'B2'],
            ['name' => 'C1'],
            ['name' => 'C2'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_levels');
    }
};
