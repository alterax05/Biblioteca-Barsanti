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
        if(Schema::hasTable('prenotazioni')) {
            return;
        }

        Schema::create('prenotazioni', function (Blueprint $table) {
            $table->id('id_prenotazione');
            $table->foreignId('user')->constrained('users');
            $table->foreignId('id_copia')->constrained('copie', 'id_copia');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prenotazioni');
    }
};
