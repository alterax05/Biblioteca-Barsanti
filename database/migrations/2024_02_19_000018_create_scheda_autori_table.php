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
        if (Schema::hasTable('scheda_autori')) {
            return;
        }

        Schema::create('scheda_autori', function (Blueprint $table) {
            $table->foreignId('id_autore')->constrained('autori', 'id_autore'); 
            $table->primary('id_autore');
            $table->string('location', 100);
            $table->foreignId('id_nazione')->constrained('nazioni', 'id_nazione');
            $table->year('anno_nascita');
            $table->year('anno_morte')->nullable();
            $table->string('avatar', 200);
            $table->text('descrizione');
            $table->year('nobel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheda_autori');
    }
};
