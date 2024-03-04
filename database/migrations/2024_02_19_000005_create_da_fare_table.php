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
        if(Schema::hasTable('copie_da_fare')) {
            return;
        }
        Schema::create('copie_da_fare', function (Blueprint $table) {
            $table->foreignId('id_copia')->constrained('copie', 'id_copia');
            $table->foreignId('ISBN')->constrained('libri', 'ISBN');
            $table->primary(['id_copia', 'ISBN']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copie_da_fare');
    }
};
