<?php

namespace Database\Seeders;

use App\Models\FrontSetting;
use Illuminate\Database\Seeder;

class CreateFrontSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $featured_jobs_price = FrontSetting::where('key', 'featured_jobs_price')->first();
        if (isset($featured_jobs_price)) {
            $featured_jobs_price->update([
                'value' => 0,
            ]);
        } else {
            FrontSetting::create(['key' => 'featured_jobs_price', 'value' => 0]);
        }
        $featured_jobs_days = FrontSetting::where('key', 'featured_jobs_days')->first();
        if (isset($featured_jobs_days)) {
            $featured_jobs_days->update([
                'value' => 10,
            ]);
        } else {
            FrontSetting::create(['key' => 'featured_jobs_days', 'value' => 10]);
        }
        $featured_jobs_quota = FrontSetting::where('key', 'featured_jobs_quota')->first();
        if (isset($featured_jobs_quota)) {
            $featured_jobs_quota->update([
                'value' => 10,
            ]);
        } else {
            FrontSetting::create(['key' => 'featured_jobs_quota', 'value' => 10]);
        }
        $featured_companies_price = FrontSetting::where('key', 'featured_companies_price')->first();
        if (isset($featured_companies_price)) {
            $featured_companies_price->update([
                'value' => 0,
            ]);
        } else {
            FrontSetting::create(['key' => 'featured_companies_price', 'value' => 0]);
        }
        $featured_companies_days = FrontSetting::where('key', 'featured_companies_days')->first();
        if (isset($featured_companies_days)) {
            $featured_companies_days->update([
                'value' => 10,
            ]);
        } else {
            FrontSetting::create(['key' => 'featured_companies_days', 'value' => 10]);
        }
        $featured_companies_quota = FrontSetting::where('key', 'featured_companies_quota')->first();
        if (isset($featured_companies_quota)) {
            $featured_companies_quota->update([
                'value' => 10,
            ]);
        } else {
            FrontSetting::create(['key' => 'featured_companies_quota', 'value' => 10]);
        }
        $featured_jobs_enable = FrontSetting::where('key', 'featured_jobs_enable')->first();
        if (isset($featured_jobs_enable)) {
            $featured_jobs_enable->update([
                'value' => false,
            ]);
        } else {
            FrontSetting::create(['key' => 'featured_jobs_enable', 'value' => false]);
        }
        $featured_companies_enable = FrontSetting::where('key', 'featured_companies_enable')->first();
        if (isset($featured_companies_enable)) {
            $featured_companies_enable->update([
                'value' => false,
            ]);
        } else {
            FrontSetting::create(['key' => 'featured_companies_enable', 'value' => false]);
        }
        $currency = FrontSetting::where('key', 'currency')->first();
        if (isset($currency)) {
            $currency->update([
                'value' => 64,
            ]);
        } else {
            FrontSetting::create(['key' => 'currency', 'value' => 64]);
        }
    }
}
