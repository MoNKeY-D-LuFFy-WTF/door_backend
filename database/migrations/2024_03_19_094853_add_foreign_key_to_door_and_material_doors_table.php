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
        Schema::table('door_and_material_doors', function (Blueprint $table) {
            $table->unsignedBigInteger('door_id')->after('door_material_id');
            $table->foreign('door_id')->references('id')->on('doors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('door_and_material_doors', function (Blueprint $table) {
            $table->dropForeign(['door_id']);
            $table->dropColumn('door_id');
        });
    }
};
