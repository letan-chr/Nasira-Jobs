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
        Schema::table('jobs', function (Blueprint $table) {
            $table->unsignedInteger('career_level_id')->nullable()->change();
            $table->unsignedInteger('job_shift_id')->nullable()->change();
            $table->unsignedInteger('degree_level_id')->nullable()->change();
            $table->unsignedInteger('no_preference')->nullable()->change();
        });
    }
};
