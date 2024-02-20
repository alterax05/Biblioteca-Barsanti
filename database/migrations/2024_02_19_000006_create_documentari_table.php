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
        if(Schema::hasTable('documentari')) {
            return;
        }

        Schema::create('documentari', function (Blueprint $table) {
            $table->id('id_documentario');
            $table->string('titolo', 200);
            $table->string('subtitolo', 100)->nullable();
            $table->foreignId('uploader')->constraint('utenti');
            $table->string('embed', 100);
            $table->string('thumbnail', 200);
            $table->string('link', 200);
            $table->integer('tipologia')->unsigned()->references('reparto')->on('id_reparto');
            $table->integer('fornitore')->unsigned()->references('id_fornitore')->on('fornitori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentari');
    }
};
