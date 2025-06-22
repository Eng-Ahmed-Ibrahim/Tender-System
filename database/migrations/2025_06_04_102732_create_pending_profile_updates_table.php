<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pending_profile_updates', function (Blueprint $table) {
            $table->id();
                $table->foreignId('user_id')->constrained();
                $table->string("email")->nullable();
                $table->string("phone")->nullable();
                $table->string("otp");
                $table->boolean("is_verified")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_profile_updates');
    }
};
