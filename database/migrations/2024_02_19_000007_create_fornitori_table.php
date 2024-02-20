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
        if(Schema::hasTable('fornitori')) {
            return;
        }
        
        Schema::create('fornitori', function (Blueprint $table) {
            $table->id('id_fornitore');
            $table->string('fornitore', 100)->nullable(false);
            $table->string('icona', 100)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornitori');
    }
};
