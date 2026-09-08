<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('gallery_registers', function (Blueprint $table) {
            $table->id();

            // Owner Details
            $table->string('owner_name');
            $table->string('owner_surname');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password')->after('phone');

            // Gallery / Institution Details
            $table->string('gallery_name')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('pincode')->nullable();
            $table->string('website')->nullable();

            // Curatorial Vision
            $table->text('curatorial_vision');

            // Exhibition & Programme
            $table->string('exhibition_types')->nullable();
            $table->string('past_links')->nullable();

            // Selling
            $table->enum('sell_interest', ['yes', 'later'])->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gallery_registers');
    }
};
