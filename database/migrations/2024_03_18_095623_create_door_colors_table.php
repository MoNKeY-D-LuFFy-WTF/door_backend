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
        Schema::create('door_colors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('catalog_img_id');
            $table->foreign('catalog_img_id')->references('id')->on('catalog_images');
            $table->unsignedBigInteger('door_material_id');
            $table->foreign('door_material_id')->references('id')->on('door_materials');
            $table->string('image');
            $table->integer('price');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('door_colors');
    }
};
