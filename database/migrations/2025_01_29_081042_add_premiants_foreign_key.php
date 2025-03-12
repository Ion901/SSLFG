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
        Schema::table('premiants',function(Blueprint $table) {
            $table->foreignId('id_competition')->constrained('competitions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_athlet')->constrained('athlets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('premiants',function(Blueprint $table){
            $table->dropForeign(['id_competition','id_athlet']);
        });
    }
};
