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
        Schema::table('doors', function (Blueprint $table) {
            $table->unsignedBigInteger('catalog_child_id')->after('door_color_id');
            $table->foreign('catalog_child_id')->references('id')->on('catalog_children');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doors', function (Blueprint $table) {
            $table->dropForeign(['catalog_child_id']);
            $table->dropColumn('catalog_child_id');
        });
    }
};
