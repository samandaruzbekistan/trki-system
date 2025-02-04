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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->timestamps();
        });

        $hash_password = \Illuminate\Support\Facades\Hash::make('915030089');

        \Illuminate\Support\Facades\DB::table('teachers')->insert([
            'name' => 'Шарипова Анжелика',
            'username' => 'anjelika',
            'password' => $hash_password,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
