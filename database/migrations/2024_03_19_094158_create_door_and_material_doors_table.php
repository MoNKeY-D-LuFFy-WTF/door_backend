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
        Schema::create('door_and_material_doors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('door_material_id');
            $table->foreign('door_material_id')->references('id')->on('door_materials');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('door_and_material_doors');
    }
};
