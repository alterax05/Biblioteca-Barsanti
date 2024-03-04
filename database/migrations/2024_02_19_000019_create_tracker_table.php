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
        if(Schema::hasTable('tracker')){
            return;
        }

        Schema::create('tracker', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');
            $table->date('visit_date');
            $table->time('visit_time');
            $table->integer('user')->default(0);
            $table->integer('hits')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracker');
    }
};
