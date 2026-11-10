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
        Schema::table('social_accounts', function (Blueprint $table) {
            $sa = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sa->listTableIndexes('social_accounts');

            if (array_key_exists('social_accounts_provider_unique', $indexesFound)) {
                $table->dropUnique(['provider']);
            }
        });
    }
};
