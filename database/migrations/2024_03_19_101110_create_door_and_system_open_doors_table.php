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
        Schema::create('door_and_system_open_doors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("door_id");
            $table->unsignedBigInteger('door_open_system_id');
            $table->foreign('door_id')->references('id')->on('doors');
            $table->foreign('door_open_system_id')->references('id')->on('door_open_systems');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('door_and_system_open_doors');
    }
};