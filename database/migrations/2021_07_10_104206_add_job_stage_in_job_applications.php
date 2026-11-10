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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('job_stage_id')->nullable()->after('notes');

            $table->foreign('job_stage_id')->references('id')->on('job_stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('job_applications', 'job_stage_id')) {
            Schema::table('job_applications', function (Blueprint $table) {
                $table->dropColumn('job_stage_id');
            });
        }
    }
};
