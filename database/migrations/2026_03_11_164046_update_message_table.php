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
            $table->foreignId('id_property')->nullable()->after("category");
            $table->foreignId('id_construction_site')->nullable()->after("id_property");

            $table->foreign('id_property')->references('id')->on('properties')->onDelete('set null');
            $table->foreign('id_construction_site')->references('id')->on('construction_sites')->onDelete('set null');
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
