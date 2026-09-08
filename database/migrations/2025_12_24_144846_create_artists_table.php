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
        Schema::create('artists', function (Blueprint $table) {
    $table->id();
    $table->string('first_name');
    $table->string('last_name')->nullable();
    $table->string('email')->unique();
    $table->string('phone',13)->nullable();
    $table->text('address1')->nullable();
    $table->text('address2')->nullable();
    $table->string('city')->nullable();
    $table->string('state')->nullable();
    $table->string('country')->nullable();
    $table->string('pincode')->nullable();
    $table->string('college')->nullable();
    $table->string('degree')->nullable();
    $table->string('portfolio')->nullable();
    $table->text('journey')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
