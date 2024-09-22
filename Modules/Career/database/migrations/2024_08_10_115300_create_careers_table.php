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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
   
            $table->unsignedBigInteger('normal_id');
            $table->foreign('normal_id')->references('id')->on('normal_ads')->onDelete('cascade');
            $table->string('experience_year');
            $table->string('experience_level');
            $table->string('cv_file');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
