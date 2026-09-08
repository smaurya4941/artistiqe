<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('file_original_name')->nullable();
            $table->string('file_name');
            $table->string('file_size')->nullable();
            $table->string('extension')->nullable();
            $table->string('type')->nullable(); // image, video, file
            $table->string('external_link')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
