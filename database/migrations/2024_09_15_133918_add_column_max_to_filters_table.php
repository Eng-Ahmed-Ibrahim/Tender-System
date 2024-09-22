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
        Schema::table('filters', function (Blueprint $table) {
            
            $table->decimal('min_value', 8, 2)->nullable(); // Optional min value for min/max filters
    $table->decimal('max_value', 8, 2)->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('filters', function (Blueprint $table) {
            //
        });
    }
};
