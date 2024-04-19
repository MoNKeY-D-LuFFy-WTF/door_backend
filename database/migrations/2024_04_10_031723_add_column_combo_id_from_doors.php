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
            $table->unsignedBigInteger('door_combo_id')->nullable()->after('name');
            $table->foreign('door_combo_id')->references('id')->on('door_combos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doors', function (Blueprint $table) {
            $table->dropForeign(['door_combo_id']);
            $table->dropColumn('door_combo_id');
        });
    }
};
