<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs_skill', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_id')->unsigned();
            $table->unsignedInteger('skill_id')->unsigned();
            $table->foreign('job_id')->references('id')->on('jobs')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('skill_id')->references('id')->on('skills')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs_skill');
    }
};
