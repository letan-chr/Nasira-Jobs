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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });

        // Futher
        Schema::table('required_degree_levels', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('company_sizes', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('marital_status', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('industries', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('ownership_types', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('job_types', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('career_levels', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('job_shifts', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('salary_currencies', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('salary_periods', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('functional_areas', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('job_categories', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('jobs', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('skills', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('languages', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('post_categories', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
