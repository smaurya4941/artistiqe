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
        Schema::create('collector_registers', function (Blueprint $table) {
    $table->id();

    // Personal (MANDATORY)
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->string('phone');
    $table->string('password');

    // Address
    $table->string('address_line1')->nullable();
    $table->string('address_line2')->nullable();
    $table->string('city')->nullable();
    $table->string('state')->nullable();
    $table->string('country')->nullable();
    $table->string('zip')->nullable();

    // Other
    $table->text('journey')->nullable();
    $table->string('sell_interest')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collector_registers');
    }
};
