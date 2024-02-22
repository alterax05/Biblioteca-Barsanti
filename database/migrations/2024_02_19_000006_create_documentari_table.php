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
            $table->foreignId('uploader')->constrained('users');
            $table->string('embed', 100);
            $table->string('thumbnail', 200);
            $table->string('link', 200);
            $table->foreignId('tipologia')->constrained('reparti', 'id_reparto');
            $table->foreignId('fornitore')->constrained('fornitori', 'id_fornitore');
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
