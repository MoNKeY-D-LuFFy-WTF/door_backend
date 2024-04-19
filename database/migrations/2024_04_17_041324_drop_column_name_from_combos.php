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
        Schema::table('door_combos', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->unsignedBigInteger('door_id');
            $table->foreign('door_id')->references('id')->on('doors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('door_combos', function (Blueprint $table) {
            $table->string('name');
            $table->dropForeign(['door_id']);
            $table->dropColumn('door_id');
        });
    }
};
