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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->decimal('price', 8, 2); 
            $table->string('duration')->default('monthly');
            $table->integer('normalads')->default(0); 
            $table->integer('commercialads')->default(0); 
            $table->integer('popupads')->default(0); 
            $table->integer('banners')->default(0); 
            $table->boolean('featured_ads')->default(false); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
