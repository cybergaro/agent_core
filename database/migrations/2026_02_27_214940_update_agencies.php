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
        Schema::table('agencies', function (Blueprint $table) {
            $table->boolean('enable_captcha')->default(0)->after("website_connection");
            $table->text("captcha_key")->nullable()->after("enable_captcha");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
