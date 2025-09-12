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
            $table->dropColumn('occupancy_status');
            $table->dropColumn('internal_condition');
            $table->dropColumn('furniture');
        });

        Schema::table('properties', function (Blueprint $table) {

            $table->enum('occupancy_status',[
                'occupied',
                'vacant',
            ])->default("vacant")->after("n_bathroom")->nullable();

            $table->enum('internal_condition',['new','renovated','good','excellent','original','fair','to_be_renovated'])->after("occupancy_status")->nullable();

            $table->enum('furniture',[
                'furnished',          
                'partially-furnished',
                'unfurnished', 
            ])->after("internal_condition")->nullable();
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
