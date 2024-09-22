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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBiginteger('whatsApp')->nullable();
            $table->UnsignedBiginteger('phone_number')->nullable();
            $table->string('title')->nullable();
            $table->string('email')->nullable();
            $table->string('owner_name')->nullable();
            $table->text('logo')->nullable();
            $table->text('terms_condition_en')->nullable();
            $table->text('terms_condition_ar')->nullable();
            $table->text('refund_policy_en')->nullable();
            $table->text('refund_policy_ar')->nullable();
            $table->text('privacy_policy_ar')->nullable();
            $table->text('privacy_policy_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
