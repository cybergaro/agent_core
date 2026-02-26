<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->text('google_cloud_credentials')->nullable()->after("real_smart_remove_after_delete")->comment("Queste credenziali vengono usate per accedere agli strumenti della suite di google, come google sheet");
            $table->string('google_sheet_id', 255)->nullable()->after("google_cloud_credentials");
        });
    }

    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn(['google_cloud_credentials', 'google_sheet_id']);
        });
    }
};
