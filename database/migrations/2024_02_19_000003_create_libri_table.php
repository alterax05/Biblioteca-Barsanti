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
        Schema::create('libri', function (Blueprint $table) {
            $table->id('ISBN');
            $table->string('titolo', 100);
            $table->text('descrizione');
            $table->foreignId('editore')->constrained('editori', 'id_editore');
            $table->year('anno_stampa');
            $table->smallInteger('pagine');
            $table->string('altezza', 10);
            $table->string('lingua', 2);
            $table->foreign('lingua')->references('tag_lingua')->on('lingue');
            $table->foreignId('reparto')->constrained('reparti', 'id_reparto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libri');
    }
};
