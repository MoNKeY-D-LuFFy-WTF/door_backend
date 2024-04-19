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
            $table->unsignedBigInteger('door_statuse_id');
            $table->foreign('door_statuse_id')->references('id')->on('door_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doors', function (Blueprint $table) {
            $table->dropForeign(['door_statuse_id']);
            $table->dropColumn('door_statuse_id');
        });
    }
};
