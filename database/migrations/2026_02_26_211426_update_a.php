<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropForeign(['id_user_owner']); 
    
            $table->dropColumn("id_user_owner");
        });
    }

    public function down(): void
    {

    }
};