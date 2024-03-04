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
        if(Schema::hasTable('condizioni'))
        {
            return;
        }
        
        Schema::create('condizioni', function (Blueprint $table) {
            $table->tinyIncrements('id_condizioni');
            $table->string('condizioni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condizioni');
    }
};
