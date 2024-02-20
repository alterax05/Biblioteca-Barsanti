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
        //Non esiste il modello carousel perché usato solo una volta

        if(Schema::hasTable('carousel')){
            return;
        }

        Schema::create('carousel', function (Blueprint $table) {
            $table->id('id_carousel');
            $table->string('title', 100);
            $table->string('subtitle', 100);
            $table->foreignId('autore')->constrained('autori', 'id_autore')->nullable();
            $table->string('image', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousel');
    }
};
