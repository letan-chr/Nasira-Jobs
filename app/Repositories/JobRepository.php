<?php

namespace App\Repositories;

use App\Jobs\CandidatesAlertJob;
use DB;
use to;
use Exception;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\Tag;
use App\Models\Plan;
use App\Models\User;
use App\Models\Skill;
use App\Models\Company;
use App\Models\JobType;
use App\Models\EmailJob;
use App\Models\JobShift;
use App\Models\Candidate;
use App\Models\CareerLevel;
use App\Models\JobCategory;
use App\Models\ReportedJob;
use Illuminate\Support\Str;
use App\Models\FavouriteJob;
use App\Models\FrontSetting;
use App\Models\Notification;
use App\Models\SalaryPeriod;
use App\Models\EmailTemplate;
use App\Mail\EmailJobToFriend;
use App\Mail\EmailToCandidate;
use App\Models\FunctionalArea;
use App\Models\JobApplication;
use App\Models\SalaryCurrency;
use App\Models\NotificationSetting;
use App\Models\RequiredDegreeLevel;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class JobRepository
 *
 * @version July 12, 2020, 12:34 pm UTC
 */
class JobRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'job_title',
        'is_freelance',
        'hide_salary',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Job::class;
    }

    public function prepareJobData(): array
    {
        $data['jobTypes'] = JobType::withCount(['jobs' => function ($q) {
            $q->whereStatus(Job::STATUS_OPEN)
                ->where('status', '!=', Job::STATUS_DRAFT)
                ->whereIsSuspended(Job::NOT_SUSPENDED)
                ->whereDate('job_expiry_date', '>=', Carbon::tomorrow()->toDateString());
        }])->toBase()->get();
        $data['jobCategories'] = JobCategory::toBase()->pluck('name', 'id');
        $data['jobSkills'] = Skill::toBase()->pluck('name', 'id');
        $data['genders'] = Job::NO_PREFERENCE;
        $data['careerLevels'] = CareerLevel::toBase()->pluck('level_name', 'id');
        $data['functionalAreas'] = FunctionalArea::toBase()->pluck('name', 'id');
        $data['advertise_image'] = FrontSetting::where('key', '=', 'advertise_image')->toBase()->first();

        return $data;
    }

    /**
     * @return mixed
     */
    public function prepareData()
    {
        $data['jobType'] = JobType::pluck('name', 'id');
        $data['jobCategory'] = JobCategory::pluck('name', 'id');
        $data['careerLevels'] = CareerLevel::pluck('level_name', 'id');
        $data['jobShift'] = JobShift::pluck('shift', 'id');
        $data['currencies'] = SalaryCurrency::pluck('currency_name', 'id');
        $data['salaryPeriods'] = SalaryPeriod::pluck('period', 'id');
        $data['functionalArea'] = FunctionalArea::pluck('name', 'id');
        $data['preference'] = Job::NO_PREFERENCE;
        $data['jobSkill'] = Skill::pluck('name', 'id');
        $data['jobTag'] = Tag::pluck('name', 'id');
        $data['requiredDegreeLevel'] = RequiredDegreeLevel::pluck('name', 'id');
        $data['countries'] = getCountries();
        $data['companies'] = Company::with('user')->get()->where('user.is_active', '=', 1)
            ->pluck('user.full_name', 'id')->sort();

        return $data;
    }

    /**
     * @return mixed
     */
    public function getUniqueJobId()
    {
        $jobUniqueId = Str::random(12);
        while (true) {
            $isExist = Job::whereJobId($jobUniqueId)->exists();
            if ($isExist) {
                self::getUniqueJobId();
            }
            break;
        }

        return $jobUniqueId;
    }

    /**
     * @throws \Throwable
     */
    public function store(array $input): bool
    {
        try {
            DB::beginTransaction();

            $input = $this->normalizeJobInput($input);
            $input['company_id'] = (isset($input['company_id'])) ? $input['company_id'] : Auth::user()->owner_id;
            $input['job_id'] = $this->getUniqueJobId();
            /** @var Job $job */
            if (Auth::user()->hasRole('Admin')) {
                $input['is_created_by_admin'] = 1;
            }

            $job = $this->create($input);

            if (isset($input['jobsSkill']) && ! empty($input['jobsSkill'])) {
                $job->jobsSkill()->sync($input['jobsSkill']);
            }
            if (isset($input['jobTag']) && ! empty($input['jobTag'])) {
                $job->jobsTag()->sync($input['jobTag']);
            }

            if (! empty($input['job_type_id']) && $job->status != Job::STATUS_DRAFT) {
                /** @var JobType|null $jobType */
                $jobType = JobType::with('candidateJobAlerts')->whereId($input['job_type_id'])->first();
                if ($jobType) {
                    $notificationAlertUserIds = $jobType->candidateJobAlerts->pluck('user_id');
                    $notificationAlertUsers = User::whereIn('id', $notificationAlertUserIds)->get();
                    $jobAlert = NotificationSetting::where('key', 'JOB_ALERT')->first()->value;
                    foreach ($notificationAlertUsers as $user) {
                        $jobAlert == 1 ?
                            addNotification([
                                Notification::JOB_ALERT,
                                $user->id,
                                Notification::CANDIDATE,
                                'New job posted with '.$job->job_title.', if you are interested then you can apply for this job.',
                            ]) : false;
                    }
                }
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * Empty optional fields become null so a short job form can be saved.
     */
    private function normalizeJobInput(array $input): array
    {
        foreach (['salary_from', 'salary_to'] as $salaryKey) {
            if (! array_key_exists($salaryKey, $input) || $input[$salaryKey] === '' || $input[$salaryKey] === null) {
                $input[$salaryKey] = null;
            } else {
                $input[$salaryKey] = (float) removeCommaFromNumbers($input[$salaryKey]);
            }
        }

        foreach ([
            'state_id', 'city_id', 'country_id', 'job_category_id', 'currency_id', 'salary_period_id',
            'job_type_id', 'functional_area_id', 'career_level_id', 'job_shift_id', 'degree_level_id',
            'position', 'experience', 'no_preference',
        ] as $nullableId) {
            if (! isset($input[$nullableId]) || $input[$nullableId] === '' || ! is_numeric($input[$nullableId])) {
                $input[$nullableId] = null;
            }
        }

        if (empty($input['job_expiry_date'])) {
            $input['job_expiry_date'] = null;
        }

        if (! isset($input['hide_salary'])) {
            $input['hide_salary'] = 0;
        }
        if (! isset($input['is_freelance'])) {
            $input['is_freelance'] = 0;
        }

        return $input;
    }

    /**
     * @return bool|Builder|Builder[]|Collection|Model
     *
     * @throws \Throwable
     */
    public function update($input,$job)
    {

        try {
            DB::beginTransaction();
            $input = $this->normalizeJobInput($input);
            $old_status = $job->status;

            if ($job->status == Job::STATUS_DRAFT) {
                $job->status = Job::STATUS_OPEN;
            }
            if (auth()->user()->hasRole('Employer')) {
                $is_approved = Setting::where('key','job_approved')->first();
                if ($old_status == Job::STATUS_DRAFT || $job->status == Job::SELECT_PANDING) {
                    $job->status = ($is_approved->value == 1 ? Job::SELECT_PANDING : Job::STATUS_OPEN);
                }else{
                    $job->status = Job::STATUS_OPEN;
                }
            }

            // if ($job->status!= Job::SELECT_PANDING) {
            //     if($old_status == Job::STATUS_DRAFT){
            //         dispatch(new CandidatesAlertJob($input['job_type_id']));
            //     }
            // }

            $job->update($input);

            if (isset($input['jobsSkill']) && ! empty($input['jobsSkill'])) {
                $job->jobsSkill()->sync($input['jobsSkill']);
            }
            if (isset($input['jobTag']) && ! empty($input['jobTag'])) {
                $job->jobsTag()->sync($input['jobTag']);
            } else {
                $job->jobsTag()->sync([]);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function isJobAddedToFavourite(int $jobId)
    {
        return FavouriteJob::where('user_id', Auth::user()->id)->where('job_id', $jobId)->exists();
    }

    /**
     * @return mixed
     */
    public function isJobReportedAsAbuse(int $jobId)
    {
        return ReportedJob::where('user_id', Auth::user()->id)->where('job_id', $jobId)->exists();
    }

    /**
     * @return mixed
     */
    public function getJobDetails(Job $job)
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var Candidate $candidate */
        $candidate = Candidate::findOrFail($user->candidate->id);

        /** @var JobApplicationRepository $jobApplicationRepo */
        $jobApplicationRepo = app(JobApplicationRepository::class);

        // check candidate is already applied for job
        $data['isApplied'] = $jobApplicationRepo->checkJobStatus($job->id, $candidate->id,
            JobApplication::STATUS_APPLIED);

        // check job is drafted
        $data['isJobDrafted'] = $data['isJobApplicationRejected'] = $data['isJobApplicationCompleted'] = false;
        if (! $data['isApplied']) {
            // check job is drafted or not
            $data['isJobDrafted'] = $jobApplicationRepo->checkJobStatus($job->id, $candidate->id,
                JobApplication::STATUS_DRAFT);

            $data['isJobApplicationShortlisted'] = $jobApplicationRepo->checkJobStatus($job->id, $candidate->id,
                JobApplication::SHORT_LIST);

            $data['isJobApplicationRejected'] = $jobApplicationRepo->checkJobStatus($job->id, $candidate->id,
                JobApplication::REJECTED);

            $data['isJobApplicationCompleted'] = $jobApplicationRepo->checkJobStatus($job->id, $candidate->id,
                JobApplication::COMPLETE);
        }

        $data['isJobAddedToFavourite'] = $this->isJobAddedToFavourite($job->id);
        $data['isJobReportedAsAbuse'] = $this->isJobReportedAsAbuse($job->id);

        return $data;
    }

    public function storeFavouriteJobs($input): bool
    {
        $job = Job::findOrFail($input['jobId']);
        $jobUser = Company::with('user')->findOrFail($job->company_id);
        $favouriteJob = FavouriteJob::where('user_id', $input['userId'])->where('job_id', $input['jobId'])->exists();
        if (! $favouriteJob) {
            FavouriteJob::create([
                'user_id' => $input['userId'],
                'job_id' => $input['jobId'],
            ]);
            $loggedInUser = getLoggedInUser();
            NotificationSetting::where('key', 'FOLLOW_JOB')->first()->value == 1 ?
                addNotification([
                    Notification::FOLLOW_JOB,
                    $jobUser->user->id,
                    Notification::EMPLOYER,
                    $loggedInUser->first_name.' '.$loggedInUser->last_name.' started following '.$job->job_title.'.',
                ]) : false;

            return true;
        } else {
            FavouriteJob::where('user_id', $input['userId'])->where('job_id', $input['jobId'])->delete();

            return false;
        }
    }

    public function storeReportJobAbuse($input): bool
    {
        $jobReportedAsAbuse = ReportedJob::where('user_id', $input['userId'])->where('job_id',
            $input['jobId'])->exists();
        if (! $jobReportedAsAbuse) {
            $reportedJobNote = trim($input['note']);
            if (empty($reportedJobNote)) {
                throw ValidationException::withMessages([
                    'note' => 'The Note Field is required',
                ]);
            }
            ReportedJob::create([
                'user_id' => $input['userId'],
                'job_id' => $input['jobId'],
                'note' => $input['note'],
            ]);

            return true;
        }

        return false;
    }

    public function emailJobToFriend($input): bool
    {
        try {
            DB::beginTransaction();

            /** @var EmailJob $emailJob */
            $emailJob = EmailJob::create($input);
            /** @var EmailTemplate $templateBody */
            $templateBody = EmailTemplate::whereTemplateName('Email Job To Friend')->first()['body'];
            $keyVariable = ['{{friend_name}}', '{{job_url}}', '{{from_name}}'];
            $value = [$emailJob->friend_name, $emailJob->job_url, config('app.name')];
            $body = str_replace($keyVariable, $value, $templateBody);
            $data['body'] = $body;
           Mail::to($input['friend_email'])->send(new EmailJobToFriend($data));

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function canCreateMoreJobs(): bool
    {
        /** @var Company $company */
        $company = Company::whereUserId(Auth::id())->first();

        if ($company->user->email == 'company@admin.com') {
            return true;
        }

        /** @var SubscriptionRepository $subscriptionRepo */
        $subscriptionRepo = app(SubscriptionRepository::class);
        // retrieve user's subscription
        $subscription = $subscriptionRepo->getUserSubscription($company->user_id);

        if ($subscription) {
            // retrieve job count
            $jobCount = Job::whereStatus(Job::STATUS_OPEN)->where('company_id', $company->id)->where('is_created_by_admin', 0)->count();

            $maxJobCount = Plan::whereId($subscription->plan_id)->value('allowed_jobs');

            if ($maxJobCount > $jobCount) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getReportedJobs($reportedJobID)
    {
        return ReportedJob::with(['user.candidate', 'job.company'])->without([
            'user.media', 'user.country', 'user.state', 'user.city',
        ])->select('reported_jobs.*')->orderBy('created_at',
            'desc')->findOrFail($reportedJobID);
    }
}
