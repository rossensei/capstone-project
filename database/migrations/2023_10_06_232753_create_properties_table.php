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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('description')->nullable();
            $table->string('tag_no')->unique();
            $table->date('date_acquired')->nullable();
            $table->string('status')->default('Good');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
