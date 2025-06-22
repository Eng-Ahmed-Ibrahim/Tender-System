<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('tenders', function (Blueprint $table) {
        $table->foreignId('country_id')->default(1)->constrained()->onDelete('cascade');
        $table->foreignId('city_id')->default(1)->constrained()->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('tenders', function (Blueprint $table) {
        $table->dropForeign(['country_id']);
        $table->dropForeign(['city_id']);
        $table->dropColumn(['country_id', 'city_id']);
    });
}

};
