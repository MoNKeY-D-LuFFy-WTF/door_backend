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
        DB::table('door_and_system_open_doors')->truncate();
        DB::table('door_and_material_doors')->truncate();
        DB::table('door_and_door_thicks')->truncate();
        DB::table('door_combos')->truncate();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
