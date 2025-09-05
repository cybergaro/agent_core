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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Relazioni
            $table->unsignedBigInteger('id_agency');
            $table->unsignedBigInteger('id_owner')->nullable();

            // Dati immobile
            $table->string('real_smart_id', 10)->nullable();
            $table->string('name', 255);
            $table->text('description')->nullable();

            $table->enum('contract', ['rent', 'sale'])->default('sale');
            $table->enum('type', ['residential', 'commercial', 'industrial'])->default('residential');
            $table->enum('category', ['apartment', 'villa', 'office'])->default('apartment');

            $table->decimal('price', 15, 2)->nullable();
            $table->string('zip_code', 10);
            $table->string('country', 255);
            $table->string('province', 255)->nullable();
            $table->string('city', 255);
            $table->string('area', 255)->nullable();
            $table->text('address');

            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();

            // Boolean features
            $table->boolean('parking')->default(false);
            $table->boolean('box')->default(false);
            $table->boolean('elevator')->default(false);
            $table->boolean('air_conditioning')->default(false);
            $table->boolean('garden')->default(false);
            $table->boolean('independent')->default(false);

            // Altri dettagli
            $table->string('ape', 5)->nullable();
            $table->smallInteger('year_production')->nullable();
            $table->integer('size')->nullable();
            $table->decimal('condominium_fees', 10, 2)->nullable();
            $table->smallInteger('floor')->nullable();

             // Numeri stanze
            $table->integer('n_room')->nullable();
            $table->integer('n_bathroom')->nullable();

            // Stato e caratteristiche aggiuntive
            $table->string('occupancy_status', 20)->default('free')->nullable();
            $table->string('internal_condition', 20)->nullable();
            $table->string('furniture', 20)->nullable();
            $table->string('heating_system_management', 20)->nullable();
            $table->string('heating_system_type', 20)->nullable();
            $table->string('heating_system_power', 20)->nullable();

            // Campo importazione
            $table->enum('imported_from', ['realsmart'])->nullable();

            // Soft deletes & timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('id_agency')->references('id')->on('agencies')->onDelete('cascade');
            $table->foreign('id_owner')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
