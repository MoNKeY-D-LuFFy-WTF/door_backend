<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('doors')->truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('discount');
            $table->integer('price');
            $table->integer('price_discount');
            $table->boolean('window');
            $table->boolean('soung');
            $table->unsignedBigInteger('catalog_child_id');
            $table->foreign('catalog_child_id')->references('id')->on('catalog_children');
            $table->unsignedBigInteger('door_color_id');
            $table->foreign('door_color_id')->references('id')->on('door_colors');
            $table->unsignedBigInteger('door_statuse_id');
            $table->foreign('door_statuse_id')->references('id')->on('door_statuses');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
