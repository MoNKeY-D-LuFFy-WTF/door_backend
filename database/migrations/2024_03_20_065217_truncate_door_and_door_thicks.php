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
        DB::table('door_and_door_thicks')->truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('door_and_door_thicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('door_id');
            $table->foreign('door_id')->references('id')->on('doors');
            $table->unsignedBigInteger('door_thick_id');
            $table->foreign('door_thick_id')->references('Id')->on('door_thicks');
            $table->timestamps();
        });
    }
};
