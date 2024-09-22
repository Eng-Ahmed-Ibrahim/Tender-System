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
        Schema::create('house_feature', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('house_id');
        $table->unsignedBigInteger('feature_id');
        $table->timestamps();

        $table->foreign('house_id')->references('id')->on('house')->onDelete('cascade');
        $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_feature');
    }
};
