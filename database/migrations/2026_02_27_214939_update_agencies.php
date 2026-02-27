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
            $table->text("google_cloud_credentials")->after("real_smart_remove_after_delete");
            $table->text("google_sheet_id")->after("google_cloud_credentials");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
