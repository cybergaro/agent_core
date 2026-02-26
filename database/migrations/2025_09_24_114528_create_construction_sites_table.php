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
        Schema::create('construction_sites', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Relazioni
            $table->unsignedBigInteger('id_agency');
            $table->unsignedBigInteger('id_owner')->nullable();

            // Dati cantiere
            $table->string("name");
            $table->text("description");

            // Posizione
            $table->string('zip_code', 10);
            $table->string('country', 255);
            $table->string('province', 255)->nullable();
            $table->string('city', 255);
            $table->string('area', 255)->nullable();
            $table->text('address');

            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();

            // Soft deletes & timestamps
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('id_agency')->references('id')->on('agencies')->onDelete('cascade');
            $table->foreign('id_owner')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('construction_site_units', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('id_construction_site');

            // Dati dell'unità
            $table->string("name");
            $table->text("description");
            $table->decimal('price', 15, 2)->nullable();
            $table->integer('size')->nullable();

            // Dati relativi all'avanzamento del cantiere
            $table->date("start_date")->nullable();
            $table->date("completion_date")->nullable();

            
            // Numeri stanze
            $table->smallInteger('n_floors')->nullable()->comment("Quanti piani ha l'immobile");
            $table->integer('n_room')->nullable();
            $table->integer('n_bathroom')->nullable();

            // Energia
            $table->string('ape', 5)->nullable();
            $table->string('heating_system_management', 50)->nullable();
            $table->string('heating_system_type', 50)->nullable();
            $table->string('heating_system_power', 50)->nullable();

            // Altri dati
            $table->boolean('parking')->default(false);
            $table->boolean('box')->default(false);
            $table->boolean('elevator')->default(false);
            $table->boolean('air_conditioning')->default(false);
            $table->boolean('garden')->default(false);
            $table->boolean('independent')->default(false);
            $table->boolean('green')->default(false);
            $table->boolean('luxury')->default(false);
            $table->boolean('terrace')->default(false);

            // Timestamps
            $table->timestamps();

            $table->foreign('id_construction_site')->references('id')->on('construction_sites')->onDelete('cascade');
        });

        Schema::create('construction_site_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_construction_site');
            $table->unsignedBigInteger('id_construction_site_unit')->nullable();
            $table->string('path');
            
            $table->timestamp("created_at");

            $table->foreign('id_construction_site')->references('id')->on('construction_sites')->onDelete('cascade');
            $table->foreign('id_construction_site_unit')->references('id')->on('construction_site_units')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_site_units_images');
        Schema::dropIfExists('construction_site_images');
        Schema::dropIfExists('construction_site_units');
        Schema::dropIfExists('construction_sites');
    }
};
