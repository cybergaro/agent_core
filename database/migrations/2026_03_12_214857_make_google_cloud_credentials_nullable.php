<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->text('google_cloud_credentials')->nullable()->change();
            $table->text('google_sheet_id')->nullable()->change();
        });
    }


    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->text('google_cloud_credentials')->nullable(false)->change();
            $table->text('google_sheet_id')->nullable(false)->change();
        });
    }
};
