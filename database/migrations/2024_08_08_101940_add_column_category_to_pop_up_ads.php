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
        Schema::table('pop_up_ads', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_id');


            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pop_up_ads', function (Blueprint $table) {
            //
        });
    }
};
