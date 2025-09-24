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

            $table->date("start_date")->nullable();
            $table->date("completion_date")->nullable();

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
            $table->unsignedBigInteger('id_construction_sites');

            // Dati dell'unità
            $table->string("name");
            $table->decimal('price', 15, 2)->nullable();
            $table->integer('size')->nullable();

            $table->enum('type', ['residential', 'commercial', 'industrial'])->default('residential');
            $table->enum('category', [
                // Residenziale
                'apartment',                 // Appartamento in condominio
                'single-family-house',       // Casa unifamiliare
                'multi-family-house',        // Casa plurifamiliare (es. bifamiliare, trifamiliare)
                'townhouse',                 // Villetta a schiera
                'villa',                     // Villa indipendente o a schiera
                'loft',                      // Loft, solitamente da recupero industriale
                'studio-apartment',          // Monolocale
                'penthouse',                 // Attico
                'farmhouse',                 // Casale o rustico
                'cottage',                   // Casetta o villino

                // Commerciale e direzionale
                'office',                    // Ufficio o studio
                'shop',                      // Negozio con vetrina
                'commercial-space',          // Locale commerciale generico
                'hotel',                     // Albergo o struttura ricettiva
                'restaurant',                // Ristorante
                'showroom',                  // Spazio espositivo
                'retail',                    // Spazio per la vendita al dettaglio
                'bar',                       // Bar o pub
                'theater',                   // Teatro o cinema

                // Industriale e logistica
                'industrial-warehouse',      // Capannone industriale
                'logistics-hub',             // Polo logistico
                'workshop',                  // Laboratorio artigianale o officina

                // Terreni e altro
                'agricultural-land',         // Terreno agricolo
                'building-land',             // Terreno edificabile
                'garage',                    // Garage o box auto
                'parking-lot',               // Parcheggio
                'storage-unit'               // Unità di deposito
            ])->default('apartment')->nullable();

            // Numeri stanze
            $table->smallInteger('n_floors')->nullable()->comment("Quanti piani ha l'immobile");
            $table->integer('n_room')->nullable();
            $table->integer('n_bathroom')->nullable();

            // Energia
            $table->string('ape', 5)->nullable();
            $table->string('heating_system_management', 20)->nullable();
            $table->string('heating_system_type', 20)->nullable();
            $table->string('heating_system_power', 20)->nullable();

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

            $table->foreign('id_construction_sites')->references('id')->on('construction_sites')->onDelete('cascade');
        });

        Schema::create('construction_site_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_construction_site_unit');
            $table->string('path');
            
            $table->timestamp("created_at");

            $table->foreign('id_construction_site_unit')->references('id')->on('construction_site_units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_site_images');
        Schema::dropIfExists('construction_site_units');
        Schema::dropIfExists('construction_sites');
    }
};
