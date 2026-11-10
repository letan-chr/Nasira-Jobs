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
        DB::statement('ALTER TABLE `subscriptions` CHANGE `current_period_start` `current_period_start` DATETIME NULL DEFAULT NULL, CHANGE `current_period_end` `current_period_end` DATETIME NULL DEFAULT NULL;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
