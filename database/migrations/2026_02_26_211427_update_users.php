<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('id_agency')->nullable()->after("id");
    
            $table->foreign('id_agency')->references('id')->on('agencies')->onDelete('set null');
        });

        Schema::dropIfExists('email_verify_tokens');
    }

    public function down(): void
    {

    }
};