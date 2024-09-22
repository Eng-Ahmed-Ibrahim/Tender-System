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
        Schema::create('house', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('normal_id');
            $table->foreign('normal_id')->references('id')->on('normal_ads')->onDelete('cascade');
            $table->integer('room_no')->nullable();
            $table->string('area')->nullable();
            $table->string('location')->nullable();
            $table->string('view')->nullable();
            $table->string('building_no')->nullable();
            $table->string('history')->nullable();        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house');
    }
};
