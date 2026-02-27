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
        Schema::create('construction_site_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_construction_site');
            
            $table->string('path');
            $table->text("name");
            $table->string("ext", 15);
            
            $table->timestamp("created_at");
            
            $table->foreign('id_construction_site')->references('id')->on('construction_sites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_site_documents');
    }
};
