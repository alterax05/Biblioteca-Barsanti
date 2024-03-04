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
        if(Schema::hasTable('libri_generi')) {
            return;
        }
        
        Schema::create('libri_generi', function (Blueprint $table) {
            $table->foreignId('ISBN')->constrained('libri', 'ISBN');
            $table->foreignId('id_genere')->constrained('generi', 'id_genere');
            $table->primary(['ISBN', 'id_genere']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libri_generi');
    }
};
