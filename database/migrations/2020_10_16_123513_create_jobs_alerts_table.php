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
        Schema::create('jobs_alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('candidate_id');
            $table->unsignedInteger('job_type_id');
            $table->timestamps();
            $table->foreign('candidate_id')->references('id')->on('candidates')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('job_type_id')->references('id')->on('job_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs_alerts');
    }
};
