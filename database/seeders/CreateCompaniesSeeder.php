<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use App\Repositories\CompanyRepository;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class CreateCompaniesSeeder extends Seeder
{
    public function run(): void
    {
        /** @var CompanyRepository $companyRepo */
        $companyRepo = App::make(CompanyRepository::class);

        $input = [
            'name' => 'Adam Smith',
            'email' => 'company@admin.com',
            'password' => env('DEFAULT_EMPLOYER_PASSWORD', 'NasiraEmployer!ChangeMe2026'),
            'is_verified' => 1,
            'ceo' => 'Chris Silver',
            'industry_id' => rand(1, 5),
            'ownership_type_id' => rand(1, 5),
            'company_size_id' => rand(1, 4),
            'established_in' => 2020,
            'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
            'location' => 'USA',
            'no_of_offices' => rand(1, 10),
            'website' => 'https://www.google.com',
            'is_active' => 1,
            'is_featured' => rand(1, 0),
            'facebook_url' => 'https://www.facebook.com',
            'twitter_url' => 'https://www.twitter.com',
            'linkedin_url' => 'https://www.linkedin.com',
            'google_plus_url' => 'https://www.googleplus.com',
            'pinterest_url' => 'https://www.pinterest.com',
            'is_default' => 1,
        ];

        $companyRepo->store($input);

        $faker = Faker::create();
        foreach (range(1, 20) as $index) {
            try {
                $input = [
                    'name' => $faker->firstName(),
                    'email' => $faker->unique()->email(),
                    'password' => env('DEFAULT_EMPLOYER_PASSWORD', 'NasiraEmployer!ChangeMe2026'),
                    'phone' => $faker->phoneNumber(),
                    'dob' => Carbon::now()->subYears(25),
                    'gender' => rand(0, 1),
                    'ceo' => $faker->name(),
                    'industry_id' => rand(1, 5),
                    'ownership_type_id' => rand(1, 5),
                    'company_size_id' => rand(1, 4),
                    'established_in' => 2020,
                    'details' => $faker->realText(250),
                    'location' => $faker->country(),
                    'no_of_offices' => rand(1, 10),
                    'website' => $faker->domainName(),
                    'is_active' => 1,
                    'is_verified' => 1,
                    'is_featured' => rand(1, 0),
                    'fax' => $faker->e164PhoneNumber(),
                    'facebook_url' => 'https://www.facebook.com',
                    'twitter_url' => 'https://www.twitter.com',
                    'linkedin_url' => 'https://www.linkedin.com',
                    'google_plus_url' => 'https://www.googleplus.com',
                    'pinterest_url' => 'https://www.pinterest.com',
                    'is_default' => 1,
                    //                    'image_url'         => asset('web/img/cmp_'.rand(1, 20).'.jpg'),
                ];

                // add state and city according to selected country
                $states = State::whereHas('country')->pluck('id', 'country_id')->toArray();
                $input['country_id'] = Arr::random(array_keys($states));
                $input['state_id'] = $states[$input['country_id']];
                if (isset($input['state_id'])) {
                    $cities = City::where('state_id', $input['state_id'])->pluck('id')->toArray();
                    $input['city_id'] = count($cities) > 0 ? Arr::random($cities) : null;
                }

                $companyRepo->store($input);
            } catch (Exception $e) {
                echo '<pre>';
                print_r($e->getMessage());
                exit;
            }
        }
    }
}
