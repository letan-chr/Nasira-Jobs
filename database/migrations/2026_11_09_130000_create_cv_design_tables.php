<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_templates', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('category')->default('modern');
            $table->string('accent_color', 20)->default('#006837');
            $table->string('secondary_color', 20)->nullable();
            $table->string('layout')->default('classic');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('candidate_cv_designs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('cv_template_id')->constrained('cv_templates')->cascadeOnDelete();
            $table->string('title')->default('My CV');
            $table->json('content');
            $table->json('settings')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_cv_designs');
        Schema::dropIfExists('cv_templates');
    }
};
