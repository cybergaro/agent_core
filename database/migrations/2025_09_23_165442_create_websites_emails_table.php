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
        Schema::create('websites_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_agency');
            $table->string("name")->nullable();
            $table->string("tel")->nullable();
            $table->string("email")->nullable();
            $table->integer("n_room")->nullable();
            $table->integer("size")->nullable();
            $table->text("address")->nullable();
            $table->text("description")->nullable();
            $table->timestamp("created_at");

            $table->foreign('id_agency')->references('id')->on('agencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites_emails');
    }
};
