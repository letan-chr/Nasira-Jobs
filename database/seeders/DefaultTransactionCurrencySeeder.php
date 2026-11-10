<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DefaultTransactionCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plan = Plan::groupBy('salary_currency_id')->selectRaw('salary_currency_id, count(*) as total')->pluck('total', 'salary_currency_id')->toArray();
        $maxUsedPlan = max($plan);
        $currency_id = array_search($maxUsedPlan, $plan);
        Transaction::whereNull('plan_currency_id')->update(['plan_currency_id' => $currency_id]);
    }
}
