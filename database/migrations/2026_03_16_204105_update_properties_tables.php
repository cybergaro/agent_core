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
        Schema::table('properties_images', function (Blueprint $table) {
            $table->text('original_url')->nullable()->after("path")->comment("Questo campo viene usato se l'immobile è stato importato per tenere traccia dell'immagine originale");
        });

        Schema::table('properties_360_images', function (Blueprint $table) {
            $table->text('original_url')->nullable()->after("path")->comment("Questo campo viene usato se l'immobile è stato importato per tenere traccia dell'immagine originale");
        });

        Schema::table('properties_floor_plans', function (Blueprint $table) {
            $table->text('original_url')->nullable()->after("path")->comment("Questo campo viene usato se l'immobile è stato importato per tenere traccia dell'immagine originale");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
