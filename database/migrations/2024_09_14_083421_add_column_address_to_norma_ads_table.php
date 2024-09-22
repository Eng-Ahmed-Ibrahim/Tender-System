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
        Schema::table('normal_ads', function (Blueprint $table) {
            $table->string('address');
            $table->enum('listing_type', ['general', 'car', 'house', 'device','career','bikes'])->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('norma_ads', function (Blueprint $table) {
            //
        });
    }
};
