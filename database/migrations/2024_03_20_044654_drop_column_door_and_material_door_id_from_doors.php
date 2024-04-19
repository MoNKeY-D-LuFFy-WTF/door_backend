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
            $table->dropColumn('door_and_material_door_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doors', function (Blueprint $table) {
            $table->unsignedBigInteger('door_and_material_door_id');
        });
    }
};
