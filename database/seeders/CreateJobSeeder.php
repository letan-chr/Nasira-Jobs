<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use App\Repositories\JobRepository;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CreateJobSeeder extends Seeder
{
    /**
     * @throws \Throwable
     */
    public function run(): void
    {
        $users = \App\Models\User::whereOwnerType(\App\Models\Company::class)->pluck('id')->toArray();
        /** @var \App\Repositories\JobRepository $jobRepo */
        $jobRepo = App::make(JobRepository::class);
        $faker = Faker::create();
        foreach (range(1, 40) as $index) {
            try {
                $input = [
                    'job_title' => $faker->jobTitle(),
                    'currency_id' => rand(1, 5),
                    'salary_period_id' => rand(1, 3),
                    'job_category_id' => rand(1, 8),
                    'job_type_id' => rand(1, 8),
                    'career_level_id' => rand(1, 8),
                    'functional_area_id' => rand(1, 8),
                    'job_shift_id' => rand(1, 8),
                    'degree_level_id' => rand(1, 5),
                    'position' => rand(1, 5),
                    'is_featured' => rand(1, 0),
                    'company_id' => rand(1, 19),
                    'description' => $faker->realText(200),
                    'salary_from' => rand(10000, 25000),
                    'salary_to' => rand(30000, 450000),
                    'job_expiry_date' => Carbon::now()->addMonth(),
                    'no_preference' => rand(0, 1),
                    'hide_salary' => rand(1, 0),
                    'is_freelance' => rand(1, 0),
                    'is_default' => 1,
                ];

                Auth::loginUsingId(Arr::random($users));

                // add state and city according to selected country
                $states = State::whereHas('country')->pluck('id', 'country_id')->toArray();
                $input['country_id'] = Arr::random(array_keys($states));
                $input['state_id'] = $states[$input['country_id']];

                if (isset($input['state_id'])) {
                    $cities = City::where('state_id', $input['state_id'])->pluck('id')->toArray();
                    $input['city_id'] = count($cities) > 0 ? Arr::random($cities) : null;
                }

                $jobRepo->store($input);
            } catch (\Exception $e) {
            }
        }
    }
}
