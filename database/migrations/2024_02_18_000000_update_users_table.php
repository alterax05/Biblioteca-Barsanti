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
        if(Schema::hasColumn('users', 'class')){
            return;
        }
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('class')->default('Professore');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('class');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
        });
    }
};
