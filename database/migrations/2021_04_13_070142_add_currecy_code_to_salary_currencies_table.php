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
        Schema::table('salary_currencies', function (Blueprint $table) {
            $table->string('currency_code')->after('currency_icon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('salary_currencies', 'currency_code')) {
            Schema::table('salary_currencies', function (Blueprint $table) {
                $table->dropColumn('currency_code');
            });
        }
    }
};
