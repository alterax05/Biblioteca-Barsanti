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
        if(Schema::hasTable('libri_autori')) {
            return;
        }
        
        Schema::create('libri_autori', function (Blueprint $table) {
            $table->foreignId('ISBN')->constrained('libri', 'ISBN');
            $table->foreignId('id_autore')->constrained('autori', 'id_autore');
            $table->primary(['ISBN', 'id_autore']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libri_autori');
    }
};
