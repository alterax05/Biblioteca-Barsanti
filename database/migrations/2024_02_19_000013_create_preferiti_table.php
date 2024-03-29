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
        if(Schema::hasTable('preferiti')) {
            return;
        }

        Schema::create('preferiti', function (Blueprint $table) {
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('ISBN')->constrained('libri', 'ISBN');
            $table->primary(['id_user', 'ISBN']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferiti');
    }
};
