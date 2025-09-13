<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esegui la migration.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('level')->default('info'); 
            $table->string('context')->nullable();   
            $table->text('message');                 
            $table->json('extra')->nullable();       
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Rollback della migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
