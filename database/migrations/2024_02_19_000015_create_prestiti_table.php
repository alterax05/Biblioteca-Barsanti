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
        Schema::create('prestiti', function (Blueprint $table) {
            $table->id('id_prestito');
            $table->foreignId('id_copia')->constrained('copie', 'id_copia');
            $table->foreignId('id_user')->constrained('users');
            $table->timestamp('data_inizio')->useCurrent();
            $table->timestamp('data_fine')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestiti');
    }
};
