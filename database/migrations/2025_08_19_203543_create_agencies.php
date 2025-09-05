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
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->boolean('social')->nullable();
            $table->string('stripe_product_id', 255)->nullable();
            $table->string('stripe_price_id', 255)->nullable();

            $table->timestamps();
        });

        Schema::create('agencies', function (Blueprint $table) {
            $table->id(); 
            $table->uuid('uuid')->unique();
            
            $table->unsignedBigInteger('id_user_owner')->nullable();
            $table->unsignedBigInteger('id_plan')->nullable();
            
            $table->string('name', 255);
            $table->string('email', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->text('address')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->text('logo')->nullable();
            $table->text('real_smart_xml_url')->nullable();

            $table->text('stripe_customer_id')->nullable();
            $table->boolean('enable_real_smart_importer')->default(true);
            $table->boolean('real_smart_remove_after_delete')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_user_owner')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_plan')->references('id')->on('payment_plans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
