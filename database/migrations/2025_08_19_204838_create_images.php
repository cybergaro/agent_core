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
        Schema::create('properties_floors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_property');
            $table->timestamps(); // created_at e updated_at

            // Foreign key
            $table->foreign('id_property')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
        });

        Schema::create('properties_floor_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_property');
            $table->unsignedBigInteger('id_property_floor')->nullable();
            $table->text('path');
            $table->timestamps(); // created_at e updated_at

            // Foreign keys
            $table->foreign('id_property')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');

            $table->foreign('id_property_floor')
                  ->references('id')
                  ->on('properties_floors') 
                  ->onDelete('set null');
        });

        Schema::create('properties_360_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_property');
            $table->text('path');
            $table->timestamps();

            $table->foreign('id_property')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade'); 
        });

        Schema::create('properties_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_property');
            $table->text('path');
            $table->timestamps(); // created_at e updated_at

            // Foreign key
            $table->foreign('id_property')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
        });

        Schema::create('properties_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_floor');
            $table->string('type', 50); // USER-DEFINED -> gestito come varchar
            $table->text('note')->nullable();
            $table->smallInteger('number')->default(1);
            $table->timestamps();

            // Foreign key
            $table->foreign('id_floor')
                  ->references('id')
                  ->on('properties_floors')
                  ->onDelete('cascade');
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_agency')->nullable();
            $table->string('stripe_checkout_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->unsignedBigInteger('id_plan')->nullable();
            $table->timestamp('current_period_end')->nullable();
            
            // status era USER-DEFINED: gestiamolo come enum
            $table->enum('status', ['active', 'past_due', 'canceled', 'incomplete', 'trialing'])
                  ->default('active');
            
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_agency')
                  ->references('id')
                  ->on('agencies')
                  ->onDelete('set null');

            $table->foreign('id_plan')
                  ->references('id')
                  ->on('payment_plans')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties_360_images');
    }
};
