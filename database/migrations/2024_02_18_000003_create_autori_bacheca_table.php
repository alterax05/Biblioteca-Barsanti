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
        if(Schema::hasTable('autori_bacheca'))
        {
            return;
        }
        Schema::create('autori_bacheca', function (Blueprint $table) {
            $table->foreignId('id_autore')->constrained('autori', 'id_autore');
            $table->primary('id_autore');
            $table->timestamp('created_at')->useCurrent();
            $table->string('subtitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autori_bacheca');
    }
};
