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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('model')->nullable();
            $table->string('year')->nullable();
            $table->string('kilo_meters')->nullable();
            $table->string('fuel_type')->nullable();

            $table->unsignedBigInteger('normal_id');

            $table->foreign('normal_id')->references('id')->on('normal_ads')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
