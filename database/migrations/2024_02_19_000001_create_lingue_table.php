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
        if(Schema::hasTable('lingue')) {
            return;
        }

        Schema::create('lingue', function (Blueprint $table) {
            $table->string('tag_lingua', 2)->primary();
            $table->string('lingua', 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lingue');
    }
};
