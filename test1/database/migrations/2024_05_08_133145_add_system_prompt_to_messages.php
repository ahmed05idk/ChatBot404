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
        Schema::table('messages', function (Blueprint $table) {
            $table->text('systemPrompt')->nullable()->after('userCreationId');
            // Puoi cambiare 'text' al tipo di dato che preferisci
            // 'nullable()' indica che il campo può essere nullo
            // 'after('content') indica che il campo verrà inserito dopo il campo 'content'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('systemPrompt');
            // Questo comando droppa il campo 'systemPrompt' se la migrazione viene rollbackata
        });
    }
};
