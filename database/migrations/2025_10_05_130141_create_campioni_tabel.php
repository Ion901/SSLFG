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
        Schema::create('campioni_tabel', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('titles');
            $table->string('year', 255);
            $table->text('competition');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campioni_tabel');
    }
};