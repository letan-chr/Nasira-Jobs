<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('jobs')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver !== 'mysql' && $driver !== 'mariadb') {
            return;
        }

        DB::statement('ALTER TABLE jobs MODIFY job_category_id INT UNSIGNED NULL');
        DB::statement('ALTER TABLE jobs MODIFY currency_id INT UNSIGNED NULL');
        DB::statement('ALTER TABLE jobs MODIFY salary_period_id INT UNSIGNED NULL');
        DB::statement('ALTER TABLE jobs MODIFY job_type_id INT UNSIGNED NULL');
        DB::statement('ALTER TABLE jobs MODIFY functional_area_id INT UNSIGNED NULL');
        DB::statement('ALTER TABLE jobs MODIFY position INT NULL');
        DB::statement('ALTER TABLE jobs MODIFY salary_from DOUBLE NULL');
        DB::statement('ALTER TABLE jobs MODIFY salary_to DOUBLE NULL');
        DB::statement('ALTER TABLE jobs MODIFY job_expiry_date DATE NULL');
        DB::statement('ALTER TABLE jobs MODIFY hide_salary TINYINT(1) NULL DEFAULT 0');
        DB::statement('ALTER TABLE jobs MODIFY is_freelance TINYINT(1) NULL DEFAULT 0');
    }

    public function down(): void
    {
        // Intentionally left empty — restoring NOT NULL would fail if null rows exist.
    }
};
