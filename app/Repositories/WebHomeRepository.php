<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Plan;
use App\Models\Post;
use App\Models\Skill;
use App\Models\Company;
use App\Models\Inquiry;
use App\Models\Setting;
use App\Models\Candidate;
use App\Mail\ContactEmail;
use App\Models\ImageSlider;
use App\Models\JobCategory;
use App\Models\Noticeboard;
use App\Models\Testimonial;
use App\Models\FrontSetting;
use App\Models\HeaderSlider;
use App\Models\EmailTemplate;
use App\Models\BrandingSliders;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Message;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class WebHomeRepository
 *
 * @version July 7, 2020, 5:07 am UTC
 */
class WebHomeRepository
{
    /**
     * @return mixed
     */
    public function getTestimonials()
    {
        return Testimonial::with('media')->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getDataCounts()
    {
        $data['candidates'] = Candidate::with('user')->whereHas(
            'user',
            function (Builder $query) {
                $query->where('is_active', '=', true);
            }
        )->count();
        $data['jobs'] = Job::whereStatus(Job::STATUS_OPEN)->where('status', '!=',Job::STATUS_DRAFT)->whereIsSuspended(Job::NOT_SUSPENDED)->whereDate('job_expiry_date', '>=', Carbon::tomorrow()->toDateString())->count();
        $data['resumes'] = Media::where('model_type', Candidate::class)->where('collection_name',Candidate::RESUME_PATH)
        ->join('candidates', 'media.model_id', '=', 'candidates.id')
        ->join('users', 'candidates.user_id', '=', 'users.id')->with('candidate.user')
        ->count();
        $data['companies'] = Company::with('user')->whereHas('user', function (Builder $query) {
            $query->where('is_active', '=', true);
        })->count();

        return $data;
    }

    /**
     * @return mixed
     */
    public function getLatestJobs()
    {
        return Job::with(['company', 'jobCategory', 'jobsSkill'])
            ->whereStatus(Job::STATUS_OPEN)
            ->whereIsSuspended(Job::NOT_SUSPENDED)
            ->whereDate('job_expiry_date', '>=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get()
            ->append('full_location');
    }

    /**
     * @return JobCategory[]|Builder[]|Collection
     */
    public function getCategories()
    {
        $categories = JobCategory::whereIsFeatured(1)
            ->withCount([
                'jobs' => function (Builder $q) {
                    $q->where('status', '!=', Job::STATUS_DRAFT);
                    $q->where('status', '!=', Job::STATUS_CLOSED);
                },
            ])
            ->orderBy('jobs_count', 'desc')
            ->toBase()
            ->take(8)
            ->get();

        return $categories;
    }

    public function getAllJobCategories(): \Illuminate\Support\Collection
    {
        return JobCategory::with('media','jobs')->withCount([
            'jobs' => function (Builder $q) {
                $q->whereStatus(Job::STATUS_OPEN)
                    ->where('status', '!=', Job::STATUS_DRAFT)
                    ->whereIsSuspended(Job::NOT_SUSPENDED)
                    ->whereDate('job_expiry_date', '>=', Carbon::now()->toDateString());
            },
        ])->get();
    }

    /**
     * @return Company[]|Builder[]|Collection
     */
    public function getFeaturedCompanies()
    {
        return Company::has('activeFeatured')
            ->with(['jobs', 'activeFeatured', 'user' => function ($query) {
                $query->without(['country', 'state', 'city']);
            }])
            ->whereHas('user', function (Builder $query) {
                $query->where('is_active', '=', true);
            })
            ->withCount(['jobs' => function (Builder $q) {
                $q->where('status', '!=', Job::STATUS_DRAFT);
                $q->where('status', '!=', Job::STATUS_CLOSED);
            }])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAllCompanies()
    {
        return Company::with('activeFeatured', 'jobs')->withCount(['jobs' => function (Builder $q) {
            $q->where('status', '!=', Job::STATUS_DRAFT);
            $q->where('status', '!=', Job::STATUS_CLOSED);
        }])->get();
    }

    /**
     * @return Job[]|Builder[]|Collection
     */
    public function getFeaturedJobs()
    {
        return Job::has('activeFeatured')
            ->whereStatus(Job::STATUS_OPEN)
            ->whereDate('job_expiry_date', '>=', Carbon::now()->toDateString())
            ->where('is_suspended', '=', Job::NOT_SUSPENDED)
            ->with(['company', 'jobCategory', 'jobsSkill'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @return Noticeboard[]|Builder[]|Collection
     */
    public function getNotices()
    {
        return Noticeboard::whereIsActive(true)->orderByDesc('created_at')->get();
    }

    public function storeInquires($input): bool
    {
        /** @var Inquiry $inquiry */
        $inquiry = Inquiry::create($input);
        $templateBody = EmailTemplate::whereTemplateName('Contact Us')->first();
        $keyVariable = ['{{name}}', '{{phone_no}}', '{{from_name}}'];
        $value = [$inquiry->name, $inquiry->phone_no, config('app.name')];
        $body = str_replace($keyVariable, $value, $templateBody->body);
        $data['inquiry'] = $inquiry;
        $data['body'] = $body;
    //    Mail::to($input['email'])->send(new ContactEmail($data));

       Mail::send(
        view: 'emails.contact.contact_us',
        data: [
            'data' => $data,
        ],
        callback: function (Message $message) use ($input, $data) {
            $message->to($input['email'])->from(config('mail.from.address'))->subject($data['inquiry']->subject);
        }
    );

        return true;
    }

    /**
     * @return mixed
     */
    public function getImageSlider()
    {
        $imageSliders = ImageSlider::with('media')
            ->where('is_active', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $headerSliders = HeaderSlider::with('media')
            ->where('is_active', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $settings = Setting::where('key', 'slider_is_active')->toBase()->first();
        $slider = Setting::where('key', 'is_full_slider')->toBase()->first();
        $imageSliderActive = Setting::where('key', 'is_slider_active')->toBase()->first();

        return [$imageSliders, $settings, $slider, $imageSliderActive, $headerSliders];
    }

    /**
     * @return mixed
     */
    public function getLatestJobsEnable()
    {
        return $settings = FrontSetting::where('key', 'latest_jobs_enable')->first();
    }

    /**
     * @return mixed
     */
    public function getPlans()
    {
        return $plans = Plan::with('salaryCurrency')->get()->sortBy('amount', SORT_DESC, true);
    }

    /**
     * @return BrandingSliders[]|Collection
     */
    public function getBranding()
    {
        return $branding = BrandingSliders::with('media')
            ->where('is_active', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getRecentBlog()
    {
        return $blog = Post::with(
            [
                'postAssignCategories',
                'media',
                'user' => function ($query) {
                    $query->without(['media', 'country', 'state', 'city']);
                },
            ]
        )->withCount('comments')
            ->orderBy('created_at', 'desc')->limit(3)
            ->get();
    }

    public function jobSearch($searchTerm): array
    {
        if ($searchTerm) {
            $jobSearchResult = Job::with([
                'company', 'country', 'state', 'city', 'jobShift', 'company.user', 'jobsSkill', 'jobCategory',
            ])
                ->where('job_title', 'LIKE', '%'.$searchTerm.'%')
                ->whereStatus(Job::STATUS_OPEN)->where('status', '!=',
                    Job::STATUS_DRAFT)->whereIsSuspended(Job::NOT_SUSPENDED)
                ->whereDate('job_expiry_date', '>=', Carbon::tomorrow()->toDateString())->get();
            $skills = Skill::where('name', 'LIKE', '%'.$searchTerm.'%')->get();
            $companies = Company::whereHas(
                'user',
                function (Builder $query) use ($searchTerm) {
                    $query->where('first_name', 'LIKE', '%'.$searchTerm.'%')->orWhere(
                        'last_name',
                        'LIKE',
                        '%'.$searchTerm.'%'
                    );
                }
            )->get();

            $jobTitle = [];
            $skillName = [];
            $companyName = [];
            if (! $jobSearchResult->isEmpty() || ! $skills->isEmpty() || ! $companies->isEmpty()) {
                foreach ($jobSearchResult as $jobSearch) {
                    $jobTitle[] = $jobSearch->job_title;
                }
                foreach ($skills as $skill) {
                    $skillName[] = $skill->name;
                }
                foreach ($companies as $company) {
                    $companyName[] = $company->user->full_name;
                }
            }
            $allResult = array_merge($jobTitle, $skillName, $companyName);
            $results = array_unique($allResult);

            return $results;
        }
    }
}
