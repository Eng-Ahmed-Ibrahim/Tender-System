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
        Schema::create('bike_has_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bike_id');
            $table->foreign('bike_id')->references('id')->on('bikes')->onDelete('cascade');
            $table->unsignedBigInteger('feature_id');
            $table->foreign('feature_id')->references('id')->on('bike_features')->onDelete('cascade');            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bike_has_features');
    }
};
