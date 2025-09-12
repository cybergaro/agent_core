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
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        Schema::table('properties', function (Blueprint $table) {
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
            ])->default('apartment')->after("type")->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
