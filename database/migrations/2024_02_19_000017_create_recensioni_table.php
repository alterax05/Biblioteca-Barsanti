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
        if (Schema::hasTable('recensioni')) {
            return;
        }

        Schema::create('recensioni', function (Blueprint $table) {
            $table->foreignId('ISBN')->constrained('libri', 'ISBN');
            $table->foreignId('user')->constrained('users');
            $table->unsignedInteger('punteggio');
            $table->primary(['ISBN', 'user']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recensioni');
    }
};
