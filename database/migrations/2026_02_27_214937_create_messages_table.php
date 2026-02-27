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
        Schema::dropIfExists('websites_emails');

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_agency');
            $table->string("name", 255)->nullable();
            $table->string("email", 255)->nullable();
            $table->string("tel", 30)->nullable();
            $table->text("message")->nullable();
            $table->enum('category', ['buy', 'sell', 'evaluation', 'visit_buy', 'rent', 'let', 'visit_rent', 'management', 'mortgage', 'technical', 'construction', 'job', 'other'])->default('other')->comment('Categoria della richiesta di contatto dal sito web');
            $table->text("json")->nullable();
            $table->timestamp("created_at");

            $table->foreign('id_agency')->references('id')->on('agencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
