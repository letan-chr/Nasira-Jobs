<?php

namespace Database\Seeders;

use App\Models\BrandingSliders;
use App\Models\Candidate;
use App\Models\CandidateEducation;
use App\Models\CandidateExperience;
use App\Models\City;
use App\Models\Company;
use App\Models\CompanySize;
use App\Models\EmailJob;
use App\Models\FAQ;
use App\Models\FavouriteCompany;
use App\Models\FavouriteJob;
use App\Models\FeaturedRecord;
use App\Models\HeaderSlider;
use App\Models\ImageSlider;
use App\Models\Industry;
use App\Models\Inquiry;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobApplicationSchedule;
use App\Models\JobCategory;
use App\Models\JobShift;
use App\Models\JobStage;
use App\Models\JobType;
use App\Models\Language;
use App\Models\MaritalStatus;
use App\Models\NewsLetter;
use App\Models\Noticeboard;
use App\Models\OwnerShipType;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\ReportedJob;
use App\Models\ReportedToCompany;
use App\Models\SalaryPeriod;
use App\Models\Skill;
use App\Models\State;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\Transaction;
use App\Models\User;
use App\ReportedToCandidate;
use App\Repositories\Candidates\CandidateRepository;
use App\Repositories\CompanyRepository;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    private const TARGET = 10;

    private $faker;

    private array $location = [];

    public function run(): void
    {
        $this->faker = Faker::create();
        $this->location = $this->pickLocation();

        $this->padLookups();
        $this->padCompanies();
        $this->padCandidates();
        $this->padJobs();
        $this->padJobRelations();
        $this->padCandidateProfile();
        $this->padApplications();
        $this->padEngagement();
        $this->padCmsContent();
        $this->padPosts();
        $this->padSliders();
        $this->padTransactionsAndFeatured();
    }

    private function need(string $table): int
    {
        $count = DB::table($table)->count();

        return max(0, self::TARGET - $count);
    }

    private function pickLocation(): array
    {
        $city = City::query()
            ->whereNotNull('state_id')
            ->inRandomOrder()
            ->first();

        if (! $city) {
            return ['country_id' => null, 'state_id' => null, 'city_id' => null];
        }

        $state = State::find($city->state_id);

        return [
            'country_id' => $state?->country_id ?? $city->country_id ?? null,
            'state_id' => $city->state_id,
            'city_id' => $city->id,
        ];
    }

    private function randomId(string $table, string $column = 'id'): int
    {
        $id = DB::table($table)->inRandomOrder()->value($column);
        if (! $id) {
            throw new \RuntimeException("No rows found in {$table}");
        }

        return (int) $id;
    }

    private function padLookups(): void
    {
        $this->safeCreate($this->need('industries'), function () {
            Industry::create([
                'name' => 'Industry '.Str::uuid(),
                'description' => $this->faker->sentence(),
                'is_default' => 0,
            ]);
        });

        $this->safeCreate($this->need('ownership_types'), function () {
            OwnerShipType::create([
                'name' => 'Ownership '.Str::uuid(),
                'description' => $this->faker->sentence(),
            ]);
        });

        $this->safeCreate($this->need('company_sizes'), function () {
            $from = $this->faker->unique()->numberBetween(200, 9000);
            CompanySize::create([
                'size' => $from.'-'.($from + 99),
                'is_default' => 0,
            ]);
        });

        $this->safeCreate($this->need('marital_status'), function () {
            MaritalStatus::create([
                'marital_status' => 'Status '.Str::uuid(),
                'description' => $this->faker->sentence(),
                'is_default' => 0,
            ]);
        });

        $this->safeCreate($this->need('salary_periods'), function () {
            SalaryPeriod::create([
                'period' => 'Period '.Str::uuid(),
                'description' => $this->faker->sentence(),
                'is_default' => 0,
            ]);
        });

        $this->safeCreate($this->need('job_categories'), function () {
            JobCategory::create([
                'name' => 'Category '.Str::uuid(),
                'description' => $this->faker->sentence(),
                'is_featured' => 0,
                'is_default' => 0,
            ]);
        });

        $this->safeCreate($this->need('job_types'), function () {
            JobType::create([
                'name' => 'Type '.Str::uuid(),
                'description' => $this->faker->sentence(),
                'is_default' => 0,
            ]);
        });

        $this->safeCreate($this->need('job_shifts'), function () {
            JobShift::create([
                'shift' => 'Shift '.Str::uuid(),
                'description' => $this->faker->sentence(),
                'is_default' => 0,
            ]);
        });

        $this->safeCreate($this->need('skills'), function () {
            Skill::create([
                'name' => 'Skill '.Str::uuid(),
                'description' => $this->faker->sentence(),
                'is_default' => 0,
            ]);
        });

        $this->safeCreate($this->need('tags'), function () {
            Tag::create([
                'name' => 'Tag '.Str::uuid(),
                'description' => $this->faker->sentence(),
                'is_default' => 0,
            ]);
        });

        $this->safeCreate($this->need('languages'), function () {
            Language::create([
                'language' => 'Lang '.Str::uuid(),
                'iso_code' => strtoupper(Str::random(3)),
                'is_default' => 0,
            ]);
        });

        $this->safeCreate($this->need('post_categories'), function () {
            PostCategory::create([
                'name' => 'Blog Cat '.Str::uuid(),
                'description' => $this->faker->sentence(),
                'is_default' => 0,
            ]);
        });
    }

    private function safeCreate(int $times, callable $callback): void
    {
        for ($i = 0; $i < $times; $i++) {
            try {
                $callback($i);
            } catch (\Throwable $e) {
                $this->command?->warn('Lookup seed skip: '.$e->getMessage());
            }
        }
    }

    private function padCompanies(): void
    {
        /** @var CompanyRepository $companyRepo */
        $companyRepo = App::make(CompanyRepository::class);
        $password = env('DEFAULT_DEMO_PASSWORD', 'NasiraDemo!ChangeMe2026');
        $need = $this->need('companies');

        for ($i = 1; $i <= $need; $i++) {
            $n = Company::count() + 1;
            try {
                $companyRepo->store(array_merge([
                    'name' => $this->faker->company().' '.$n,
                    'email' => "employer{$n}@test.nasira.local",
                    'password' => $password,
                    'phone' => $this->faker->numerify('09########'),
                    'is_verified' => 1,
                    'is_active' => 1,
                    'ceo' => $this->faker->name(),
                    'industry_id' => $this->randomId('industries'),
                    'ownership_type_id' => $this->randomId('ownership_types'),
                    'company_size_id' => $this->randomId('company_sizes'),
                    'established_in' => $this->faker->numberBetween(1995, 2024),
                    'details' => $this->faker->paragraphs(2, true),
                    'location' => $this->faker->city(),
                    'no_of_offices' => $this->faker->numberBetween(1, 8),
                    'website' => 'https://example.com',
                    'is_featured' => 0,
                    'is_default' => 1,
                    'facebook_url' => 'https://www.facebook.com',
                    'twitter_url' => 'https://www.twitter.com',
                    'linkedin_url' => 'https://www.linkedin.com',
                ], $this->location));
            } catch (\Throwable $e) {
                $this->command?->warn('Company seed skip: '.$e->getMessage());
            }
        }
    }

    private function padCandidates(): void
    {
        /** @var CandidateRepository $candidateRepo */
        $candidateRepo = App::make(CandidateRepository::class);
        $password = env('DEFAULT_DEMO_PASSWORD', 'NasiraDemo!ChangeMe2026');
        $need = $this->need('candidates');

        for ($i = 1; $i <= $need; $i++) {
            $n = Candidate::count() + 1;
            try {
                $candidateRepo->store(array_merge([
                    'first_name' => $this->faker->firstName(),
                    'last_name' => $this->faker->lastName(),
                    'email' => "candidate{$n}@test.nasira.local",
                    'password' => $password,
                    'phone' => $this->faker->numerify('09########'),
                    'gender' => $this->faker->numberBetween(0, 1),
                    'dob' => Carbon::now()->subYears($this->faker->numberBetween(22, 40))->toDateString(),
                    'is_active' => 1,
                    'is_verified' => 1,
                    'father_name' => $this->faker->name(),
                    'marital_status_id' => $this->randomId('marital_status'),
                    'nationality' => 'Ethiopian',
                    'experience' => $this->faker->numberBetween(0, 10),
                    'career_level_id' => $this->randomId('career_levels'),
                    'industry_id' => $this->randomId('industries'),
                    'functional_area_id' => $this->randomId('functional_areas'),
                    'current_salary' => $this->faker->numberBetween(5000, 20000),
                    'expected_salary' => $this->faker->numberBetween(20000, 50000),
                    'immediate_available' => 1,
                    'address' => $this->faker->address(),
                    'candidateSkills' => Skill::inRandomOrder()->limit(3)->pluck('id')->toArray(),
                    'candidateLanguage' => Language::inRandomOrder()->limit(2)->pluck('id')->toArray(),
                ], $this->location));
            } catch (\Throwable $e) {
                $this->command?->warn('Candidate seed skip: '.$e->getMessage());
            }
        }
    }

    private function padJobs(): void
    {
        $need = $this->need('jobs');
        $companyUsers = User::where('owner_type', Company::class)->pluck('id')->toArray();
        if (empty($companyUsers)) {
            $this->command?->warn('No employer users; skipping jobs.');

            return;
        }

        for ($i = 0; $i < $need; $i++) {
            Auth::loginUsingId(Arr::random($companyUsers));
            $companyId = Auth::user()->owner_id;
            $jobId = strtoupper(Str::random(8));
            while (Job::where('job_id', $jobId)->exists()) {
                $jobId = strtoupper(Str::random(8));
            }

            try {
                $job = Job::create(array_merge([
                    'job_id' => $jobId,
                    'job_title' => $this->faker->jobTitle(),
                    'description' => $this->faker->paragraphs(3, true),
                    'key_responsibilities' => $this->faker->paragraphs(2, true),
                    'salary_from' => $this->faker->numberBetween(8000, 25000),
                    'salary_to' => $this->faker->numberBetween(26000, 80000),
                    'company_id' => $companyId,
                    'job_category_id' => $this->randomId('job_categories'),
                    'currency_id' => $this->randomId('salary_currencies'),
                    'salary_period_id' => $this->randomId('salary_periods'),
                    'job_type_id' => $this->randomId('job_types'),
                    'career_level_id' => $this->randomId('career_levels'),
                    'functional_area_id' => $this->randomId('functional_areas'),
                    'job_shift_id' => $this->randomId('job_shifts'),
                    'degree_level_id' => $this->randomId('required_degree_levels'),
                    'position' => $this->faker->numberBetween(1, 5),
                    'experience' => $this->faker->numberBetween(0, 8),
                    'job_expiry_date' => Carbon::now()->addMonths(2)->toDateString(),
                    'no_preference' => 1,
                    'hide_salary' => 0,
                    'is_freelance' => 0,
                    'is_suspended' => 0,
                    'status' => Job::STATUS_OPEN,
                    'is_default' => 1,
                    'is_created_by_admin' => 0,
                ], $this->location));

                $skillIds = Skill::inRandomOrder()->limit(3)->pluck('id')->toArray();
                $tagIds = Tag::inRandomOrder()->limit(2)->pluck('id')->toArray();
                $job->jobsSkill()->sync($skillIds);
                $job->jobsTag()->sync($tagIds);
            } catch (\Throwable $e) {
                $this->command?->warn('Job seed skip: '.$e->getMessage());
            }
        }

        Auth::logout();
    }

    private function padJobRelations(): void
    {
        // Ensure pivot tables reach ~10 rows if jobs exist
        $jobs = Job::pluck('id')->toArray();
        if (empty($jobs)) {
            return;
        }

        $skillTries = 0;
        while (DB::table('jobs_skill')->count() < self::TARGET && $skillTries < 40) {
            $skillTries++;
            $jobId = Arr::random($jobs);
            $skillId = $this->randomId('skills');
            if (! DB::table('jobs_skill')->where(['job_id' => $jobId, 'skill_id' => $skillId])->exists()) {
                DB::table('jobs_skill')->insert(['job_id' => $jobId, 'skill_id' => $skillId]);
            }
        }

        $tagTries = 0;
        while (DB::table('jobs_tag')->count() < self::TARGET && $tagTries < 40) {
            $tagTries++;
            $jobId = Arr::random($jobs);
            $tagId = $this->randomId('tags');
            if (! DB::table('jobs_tag')->where(['job_id' => $jobId, 'tag_id' => $tagId])->exists()) {
                DB::table('jobs_tag')->insert(['job_id' => $jobId, 'tag_id' => $tagId]);
            }
        }

        $companies = Company::pluck('id')->toArray();
        $stageNames = ['Applied', 'Screening', 'Interview', 'Technical', 'HR Round', 'Offer', 'Hired', 'Rejected', 'On Hold', 'Reference Check'];
        $__n = $this->need('job_stages');
        for ($i = 0; $i < $__n; $i++) {
            JobStage::create([
                'name' => $stageNames[$i % count($stageNames)].' '.$this->faker->numerify('##'),
                'description' => $this->faker->sentence(),
                'company_id' => Arr::random($companies),
            ]);
        }
    }

    private function padCandidateProfile(): void
    {
        $candidates = Candidate::pluck('id')->toArray();
        if (empty($candidates)) {
            return;
        }

        $__n = $this->need('candidate_educations');
        for ($i = 0; $i < $__n; $i++) {
            CandidateEducation::create(array_merge([
                'candidate_id' => Arr::random($candidates),
                'degree_level_id' => $this->randomId('required_degree_levels'),
                'degree_title' => $this->faker->bs(),
                'institute' => $this->faker->company().' University',
                'result' => $this->faker->randomElement(['3.2', '3.5', '3.8', 'Distinction']),
                'year' => $this->faker->numberBetween(2010, 2024),
            ], $this->location));
        }

        $__n = $this->need('candidate_experiences');
        for ($i = 0; $i < $__n; $i++) {
            $start = Carbon::now()->subYears($this->faker->numberBetween(1, 8));
            CandidateExperience::create(array_merge([
                'candidate_id' => Arr::random($candidates),
                'experience_title' => $this->faker->jobTitle(),
                'company' => $this->faker->company(),
                'start_date' => $start->toDateString(),
                'end_date' => (clone $start)->addYears(1)->toDateString(),
                'currently_working' => 0,
                'description' => $this->faker->sentence(12),
            ], $this->location));
        }

        $candidateUsers = User::where('owner_type', Candidate::class)->pluck('id')->toArray();
        while (DB::table('candidate_skills')->count() < self::TARGET && ! empty($candidateUsers)) {
            $userId = Arr::random($candidateUsers);
            $skillId = $this->randomId('skills');
            if (! DB::table('candidate_skills')->where(['user_id' => $userId, 'skill_id' => $skillId])->exists()) {
                DB::table('candidate_skills')->insert([
                    'user_id' => $userId,
                    'skill_id' => $skillId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                static $csTries = 0;
                if (++$csTries > 40) {
                    break;
                }
            }
        }

        while (DB::table('candidate_language')->count() < self::TARGET && ! empty($candidateUsers)) {
            $userId = Arr::random($candidateUsers);
            $languageId = $this->randomId('languages');
            if (! DB::table('candidate_language')->where(['user_id' => $userId, 'language_id' => $languageId])->exists()) {
                DB::table('candidate_language')->insert([
                    'user_id' => $userId,
                    'language_id' => $languageId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                static $clTries = 0;
                if (++$clTries > 40) {
                    break;
                }
            }
        }

        while (DB::table('jobs_alerts')->count() < self::TARGET && ! empty($candidates)) {
            $candidateId = Arr::random($candidates);
            $jobTypeId = $this->randomId('job_types');
            if (! DB::table('jobs_alerts')->where(['candidate_id' => $candidateId, 'job_type_id' => $jobTypeId])->exists()) {
                DB::table('jobs_alerts')->insert([
                    'candidate_id' => $candidateId,
                    'job_type_id' => $jobTypeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                static $jaTries = 0;
                if (++$jaTries > 40) {
                    break;
                }
            }
        }
    }

    private function padApplications(): void
    {
        $jobs = Job::pluck('id')->toArray();
        $candidates = Candidate::pluck('id')->toArray();
        if (empty($jobs) || empty($candidates)) {
            return;
        }

        $__n = $this->need('job_applications');
        for ($i = 0; $i < $__n; $i++) {
            $jobId = Arr::random($jobs);
            $candidateId = Arr::random($candidates);
            if (JobApplication::where(['job_id' => $jobId, 'candidate_id' => $candidateId])->exists()) {
                continue;
            }
            JobApplication::create([
                'job_id' => $jobId,
                'candidate_id' => $candidateId,
                'resume_id' => 0,
                'expected_salary' => $this->faker->numberBetween(15000, 60000),
                'notes' => $this->faker->sentence(),
                'status' => JobApplication::STATUS_APPLIED,
                'job_stage_id' => JobStage::inRandomOrder()->value('id'),
            ]);
        }

        $applications = JobApplication::pluck('id')->toArray();
        $stages = JobStage::pluck('id')->toArray();
        if (empty($applications) || empty($stages)) {
            return;
        }

        $__n = $this->need('job_application_schedules');
        for ($i = 0; $i < $__n; $i++) {
            JobApplicationSchedule::create([
                'job_application_id' => Arr::random($applications),
                'stage_id' => Arr::random($stages),
                'time' => $this->faker->time('H:i'),
                'date' => Carbon::now()->addDays($this->faker->numberBetween(1, 30))->toDateString(),
                'notes' => $this->faker->sentence(),
                'status' => JobApplicationSchedule::STATUS_SEND,
                'batch' => 1,
            ]);
        }
    }

    private function padEngagement(): void
    {
        $jobs = Job::pluck('id')->toArray();
        $companies = Company::pluck('id')->toArray();
        $candidates = Candidate::pluck('id')->toArray();
        $candidateUsers = User::where('owner_type', Candidate::class)->pluck('id')->toArray();
        $employerUsers = User::where('owner_type', Company::class)->pluck('id')->toArray();

        if (! empty($candidateUsers) && ! empty($jobs)) {
            $__n = $this->need('favourite_jobs');
        for ($i = 0; $i < $__n; $i++) {
                $userId = Arr::random($candidateUsers);
                $jobId = Arr::random($jobs);
                if (! FavouriteJob::where(['user_id' => $userId, 'job_id' => $jobId])->exists()) {
                    FavouriteJob::create(['user_id' => $userId, 'job_id' => $jobId]);
                }
            }

            $__n = $this->need('favourite_companies');
        for ($i = 0; $i < $__n; $i++) {
                $userId = Arr::random($candidateUsers);
                $companyId = Arr::random($companies);
                if (! FavouriteCompany::where(['user_id' => $userId, 'company_id' => $companyId])->exists()) {
                    FavouriteCompany::create(['user_id' => $userId, 'company_id' => $companyId]);
                }
            }

            $__n = $this->need('reported_jobs');
        for ($i = 0; $i < $__n; $i++) {
                $userId = Arr::random($candidateUsers);
                $jobId = Arr::random($jobs);
                if (! ReportedJob::where(['user_id' => $userId, 'job_id' => $jobId])->exists()) {
                    ReportedJob::create([
                        'user_id' => $userId,
                        'job_id' => $jobId,
                        'note' => $this->faker->sentence(),
                    ]);
                }
            }

            $__n = $this->need('reported_to_companies');
        for ($i = 0; $i < $__n; $i++) {
                $userId = Arr::random($candidateUsers);
                $companyId = Arr::random($companies);
                if (! ReportedToCompany::where(['user_id' => $userId, 'company_id' => $companyId])->exists()) {
                    ReportedToCompany::create([
                        'user_id' => $userId,
                        'company_id' => $companyId,
                        'note' => $this->faker->sentence(),
                    ]);
                }
            }
        }

        if (! empty($employerUsers) && ! empty($candidates)) {
            $__n = $this->need('reported_to_candidates');
        for ($i = 0; $i < $__n; $i++) {
                $userId = Arr::random($employerUsers);
                $candidateId = Arr::random($candidates);
                if (! ReportedToCandidate::where(['user_id' => $userId, 'candidate_id' => $candidateId])->exists()) {
                    ReportedToCandidate::create([
                        'user_id' => $userId,
                        'candidate_id' => $candidateId,
                        'note' => $this->faker->sentence(),
                    ]);
                }
            }
        }

        if (! empty($candidateUsers) && ! empty($jobs)) {
            $__n = $this->need('email_jobs');
        for ($i = 0; $i < $__n; $i++) {
                $job = Job::inRandomOrder()->first();
                EmailJob::create([
                    'user_id' => Arr::random($candidateUsers),
                    'job_id' => $job->id,
                    'job_url' => url('/jobs/'.$job->job_id),
                    'friend_name' => $this->faker->name(),
                    'friend_email' => $this->faker->unique()->safeEmail(),
                ]);
            }
        }
    }

    private function padCmsContent(): void
    {
        $__n = $this->need('faqs');
        for ($i = 0; $i < $__n; $i++) {
            FAQ::create([
                'title' => $this->faker->sentence(6),
                'description' => $this->faker->paragraph(),
            ]);
        }

        $__n = $this->need('testimonials');
        for ($i = 0; $i < $__n; $i++) {
            Testimonial::create([
                'customer_name' => $this->faker->name(),
                'description' => $this->faker->paragraph(),
            ]);
        }

        $__n = $this->need('inquiries');
        for ($i = 0; $i < $__n; $i++) {
            Inquiry::create([
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
                'phone_no' => $this->faker->numerify('09########'),
                'subject' => $this->faker->sentence(4),
                'message' => $this->faker->paragraph(),
            ]);
        }

        $__n = $this->need('noticeboards');
        for ($i = 0; $i < $__n; $i++) {
            Noticeboard::create([
                'title' => $this->faker->sentence(5),
                'description' => $this->faker->paragraph(),
                'is_active' => 1,
            ]);
        }

        $__n = $this->need('news_letters');
        for ($i = 0; $i < $__n; $i++) {
            NewsLetter::create([
                'email' => 'newsletter'.$this->faker->unique()->numerify('###').'@test.nasira.local',
            ]);
        }
    }

    private function padPosts(): void
    {
        $adminId = User::where('email', 'super@admin.com')->value('id')
            ?? User::role('Admin')->value('id')
            ?? User::value('id');

        $__n = $this->need('posts');
        for ($i = 0; $i < $__n; $i++) {
            $post = Post::create([
                'title' => $this->faker->sentence(6),
                'description' => $this->faker->paragraphs(3, true),
                'created_by' => $adminId,
                'is_default' => 0,
            ]);
            $catIds = PostCategory::inRandomOrder()->limit(2)->pluck('id')->toArray();
            if (! empty($catIds)) {
                $post->postAssignCategories()->sync($catIds);
            }
        }

        $posts = Post::pluck('id')->toArray();
        if (empty($posts)) {
            return;
        }

        $__n = $this->need('post_comments');
        for ($i = 0; $i < $__n; $i++) {
            PostComment::create([
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
                'comment' => $this->faker->paragraph(),
                'user_id' => $adminId,
                'post_id' => Arr::random($posts),
            ]);
        }

        $pacTries = 0;
        while (DB::table('post_assigned_categories')->count() < self::TARGET && ! empty($posts) && $pacTries < 40) {
            $pacTries++;
            $postId = Arr::random($posts);
            $catId = $this->randomId('post_categories');
            if (! DB::table('post_assigned_categories')->where(['post_id' => $postId, 'post_categories_id' => $catId])->exists()) {
                DB::table('post_assigned_categories')->insert([
                    'post_id' => $postId,
                    'post_categories_id' => $catId,
                ]);
            }
        }
    }

    private function padSliders(): void
    {
        $__n = $this->need('image_sliders');
        for ($i = 0; $i < $__n; $i++) {
            ImageSlider::create([
                'description' => $this->faker->sentence(),
                'is_active' => 1,
            ]);
        }

        $__n = $this->need('header_sliders');
        for ($i = 0; $i < $__n; $i++) {
            HeaderSlider::create([
                'is_active' => 1,
            ]);
        }

        $__n = $this->need('branding_sliders');
        for ($i = 0; $i < $__n; $i++) {
            BrandingSliders::create([
                'title' => $this->faker->company().' Brand '.$this->faker->numerify('##'),
                'is_active' => 1,
            ]);
        }
    }

    private function padTransactionsAndFeatured(): void
    {
        $employerUsers = User::where('owner_type', Company::class)->get();
        if ($employerUsers->isEmpty()) {
            return;
        }

        $__n = $this->need('transactions');
        for ($i = 0; $i < $__n; $i++) {
            $user = $employerUsers->random();
            Transaction::create([
                'user_id' => $user->id,
                'owner_id' => $user->owner_id,
                'owner_type' => Company::class,
                'amount' => $this->faker->randomFloat(2, 10, 200),
                'invoice_id' => 'INV-'.$this->faker->unique()->numerify('######'),
                'status' => Transaction::MANUALLY,
                'is_approved' => Transaction::APPROVED,
                'plan_currency_id' => $this->randomId('salary_currencies'),
            ]);
        }

        $jobs = Job::pluck('id')->toArray();
        $companies = Company::pluck('id')->toArray();
        $__n = $this->need('featured_records');
        for ($i = 0; $i < $__n; $i++) {
            $user = $employerUsers->random();
            $useJob = ! empty($jobs) && $this->faker->boolean();
            FeaturedRecord::create([
                'owner_id' => $useJob ? Arr::random($jobs) : Arr::random($companies),
                'owner_type' => $useJob ? Job::class : Company::class,
                'user_id' => $user->id,
                'start_time' => Carbon::now()->subDays(2),
                'end_time' => Carbon::now()->addMonth(),
                'meta' => null,
            ]);
        }
    }
}
