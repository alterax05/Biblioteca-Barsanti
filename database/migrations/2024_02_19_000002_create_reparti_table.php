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
        if(Schema::hasTable('reparti'))
        {
            return;
        }

        Schema::create('reparti', function (Blueprint $table) {
            $table->id('id_reparto');
            $table->string('reparto', 50);
            $table->string('icon', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reparti');
    }
};
