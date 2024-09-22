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
        Schema::create('image_normal_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('normal_ads_id');
            $table->foreign('normal_ads_id')->references('id')->on('normal_ads')->onDelete('cascade');
            $table->string('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_normal_ads');
    }
};
