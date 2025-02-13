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
        Schema::enableForeignKeyConstraints();
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('id_category')->constrained('category')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_competition')->nullable()->constrained('competition')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['id_category']); //
            $table->dropForeign(['id_competition']); //
        });
    }
};
