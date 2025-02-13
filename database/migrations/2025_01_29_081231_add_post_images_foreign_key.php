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
        Schema::table('post_images',function(Blueprint $table) {
            $table->foreignId('id_post')->nullable()->constrained('posts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_competition')->nullable()->constrained('competition')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::enableForeignKeyConstraints();
        Schema::table('post_images',function(Blueprint $table){
            $table->dropForeign(['id_post']);
            $table->dropForeign(['id_competition']);
        });
    }
};
