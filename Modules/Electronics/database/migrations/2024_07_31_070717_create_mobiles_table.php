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
        Schema::create('mobiles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('storage');
            $table->string('ram');
            $table->string('disply_size');
            $table->integer('sim_no');
            $table->enum('status',['used','new']);
            $table->text('description');
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
        Schema::dropIfExists('mobiles');
    }
};
