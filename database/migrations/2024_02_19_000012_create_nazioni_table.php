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
        if(Schema::hasTable('nazioni')) {
            return;
        }

        Schema::create('nazioni', function (Blueprint $table) {
            $table->id('id_nazione');
            $table->string('nazione', 20)->nullable(false);
            $table->string('tag', 2)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nazioni');
    }
};
