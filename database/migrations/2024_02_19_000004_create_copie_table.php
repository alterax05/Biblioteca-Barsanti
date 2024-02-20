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
        if(Schema::hasTable('copie')) {
            return;
        }

        Schema::create('copie', function (Blueprint $table) {
            $table->id('id_copia');
            $table->integer('num_copia');
            $table->foreignId('ISBN')->constrained('libri', 'ISBN');
            $table->string('scaffale', 20);
            $table->tinyInteger('ripiano');
            $table->integer('prestati');
            $table->tinyInteger('da_catalogare')->default(0);
            $table->tinyInteger('condizioni')->unsigned()->references('id_condizione')->on('condizioni');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copie');
    }
};
