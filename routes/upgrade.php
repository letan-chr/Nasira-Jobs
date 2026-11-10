<?php

use Illuminate\Support\Facades\Route;

/**
 * Upgrade/migrate endpoints — Admin only.
 * These must never be publicly reachable.
 */
Route::middleware(['auth', 'role_or_permission:Admin|access_admin_panel'])->group(function () {

// upgrade to v4.2.0
Route::get('/upgrade-to-v4-2-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        [
            '--class' => 'AddIsFullSliderSettingSeeder',
            '--force' => true,
        ]);
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        [
            '--class' => 'AddIsSliderActiveDeactiveSeeder',
            '--force' => true,
        ]);
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        [
            '--class' => 'RenameIsActiveToSlierIsActiveInSettingSeeder',
            '--force' => true,
        ]);
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        [
            '--class' => 'AddRecordNotificationSetting',
            '--force' => true,
        ]);
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        [
            '--class' => 'UpdateNotificationSettingAdminTypeSeeder',
            '--force' => true,
        ]);
});

// upgrade to v4.4.0
Route::get('/upgrade-to-v4-4-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        [
            '--class' => 'AddEnableGoogleRecaptchaSeeder',
            '--force' => true,
        ]);
});

// upgrade to v4.5.0
Route::get('/upgrade-to-v4-5-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'RemoveProviderUniqueRuleFromSocialAccountsSeeder', '--force' => true]);
});

// upgrade to v6.0.0
Route::get('/upgrade-to-v6-0-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'FrontSettingAdvertiseImageSeeder', '--force' => true]);
});

// upgrade to v6.1.0
Route::get('/upgrade-to-v6-1-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'CreateDefaultCurrencySeeder', '--force' => true]);
});

// upgrade to v7.1.0
Route::get('/upgrade-to-v7-1-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'EmailTemplateSeeder', '--force' => true]);
});

// upgrade to v7.1.1
Route::get('/upgrade-to-v7-1-1', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'CurrencySeeder', '--force' => true]);
});

// upgrade to v8.0.0
Route::get('/upgrade-to-v8-0-0', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2021_06_29_000000_add_uuid_to_failed_jobs_table.php',
        ]);
    \Illuminate\Support\Facades\Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2021_07_1_103036_add_conversions_disk_column_in_media_table.php',
        ]);
});

// upgrade to v8.1.0
Route::get('/upgrade-to-v8-1-0', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2021_07_08_085344_create_post_comments_table.php',
        ]);
    \Illuminate\Support\Facades\Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2021_07_08_121050_add_column_is_created_by_admin_in_jobs_table.php',
        ]);
    \Illuminate\Support\Facades\Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2021_07_10_070048_create_job_stages_table.php',
        ]);
    \Illuminate\Support\Facades\Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2021_07_10_104206_add_job_stage_in_job_applications.php',
        ]);
    \Illuminate\Support\Facades\Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2021_07_10_114138_create_job_application_schedules_table.php',
        ]);
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'FooterLogoSeeder', '--force' => true]);
});

// upgrade to v9.0.0
Route::get('/upgrade-to-v9-0-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'CmsServicesSeeder', '--force' => true]);
});
// upgrade to v9.1.0
Route::get('/upgrade-to-v9-1-0', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed',
        ['--class' => 'CreateFrontSettingSeeder', '--force' => true]);
});
// upgrade to v12.2.0
Route::get('/upgrade/database', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate',
        [
            '--force' => true,
        ]);
});

});
