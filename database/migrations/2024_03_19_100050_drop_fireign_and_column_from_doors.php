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
            $table->dropForeign(['door_and_material_door_id']);
            $table->dropColumn('door_and_material_door_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doors', function (Blueprint $table) {
            $table->unsignedBigInteger('door_and_material_door_id')->after('name');
            $table->foreign('door_and_material_door_id')->references('id')->on('door_and_material_doors');
        });
    }
};
