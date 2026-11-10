<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cv_templates', function (Blueprint $table) {
            $table->longText('html')->nullable()->after('description');
            $table->longText('css')->nullable()->after('html');
            $table->longText('project_json')->nullable()->after('css');
            $table->string('thumbnail')->nullable()->after('project_json');
        });

        Schema::table('candidate_cv_designs', function (Blueprint $table) {
            $table->longText('html')->nullable()->after('content');
            $table->longText('css')->nullable()->after('html');
            $table->longText('project_json')->nullable()->after('css');
        });
    }

    public function down(): void
    {
        Schema::table('cv_templates', function (Blueprint $table) {
            $table->dropColumn(['html', 'css', 'project_json', 'thumbnail']);
        });

        Schema::table('candidate_cv_designs', function (Blueprint $table) {
            $table->dropColumn(['html', 'css', 'project_json']);
        });
    }
};
