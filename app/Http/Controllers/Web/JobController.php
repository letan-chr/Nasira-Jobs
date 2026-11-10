<?php

namespace App\Http\Controllers\Web;

use Auth;
use Carbon\Carbon;
use App\Models\Job;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\JobRepository;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\EmailJobToFriendRequest;
use Illuminate\Contracts\Foundation\Application;
use App\Models\Skill;
use App\Support\FrontSeo;


class JobController extends AppBaseController
{
    /** @var JobRepository */
    private $jobRepository;

    public function __construct(JobRepository $jobRepo)
    {
        $this->jobRepository = $jobRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request): View
    {
        $data = $this->jobRepository->prepareJobData();
        $data['input'] = $request->all();
        $data['seo'] = FrontSeo::jobsIndex($data['input']);

        return view('front_web.jobs.index')->with($data);
    }

    /**
     * @return Application|Factory|View
     */
    public function jobDetails(string $uniqueJobId)
    {
        $job = Job::with([
            'jobsTag',
            'jobCategory',
            'jobType',
            'jobShift',
            'jobsSkill',
            'company.user',
            'currency',
            'salaryPeriod',
            'country',
            'state',
            'city',
        ])->whereJobId($uniqueJobId)->first();
        $skill = Job::with('jobCategory', 'jobShift', 'jobsSkill', 'company')->whereJobId($uniqueJobId)
            ->orderByDesc('created_at')->get();
        $valuee = [];
        $counter = 1;
        foreach ($skill as $key => $value) {
            foreach ($value['jobsSkill'] as $keys => $values) {
                $valuee[$counter] = $values->name;
                $counter++;
            }
        }

        $data['skills'] = $valuee;

        if (empty($job)) {
            Flash::error('Job not found');

            return redirect()->back();
        }

        if ($job->status == Job::STATUS_DRAFT && Auth::user()->hasRole('Candidate')) {
            abort(404);
        }

        $data['resumes'] = null;

        $data['isActive'] = $data['isApplied'] = $data['isJobAddedToFavourite'] = $data['isJobReportedAsAbuse'] = false;
        if (Auth::check() && Auth::user()->hasRole('Candidate')) {
            $data = $this->jobRepository->getJobDetails($job);
        }
        $data['jobsCount'] = Job::whereStatus(Job::STATUS_OPEN)->whereCompanyId($job->company_id)->whereDate('job_expiry_date',
            '>=',
            Carbon::now()->toDateString())->count();

        // check job status is active or not
        $data['isActive'] = ($job->status == Job::STATUS_OPEN) ? true : false;

        $relatedJobs = Job::with('jobCategory', 'jobShift', 'jobsSkill', 'company')->whereJobCategoryId($job->job_category_id)
            ->whereDate('job_expiry_date', '>=', Carbon::now()->toDateString());
        $data['getRelatedJobs'] = $relatedJobs->whereNotIn('id', [$job->id])->orderByDesc('created_at')->take(6)->get();
        $url = [
            'gmail' => 'https://plus.google.com/share?url='.url()->current(),
            'twitter' => 'https://twitter.com/intent/tweet?url='.url()->current(),
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u='.url()->current(),
            'pinterest' => 'http://pinterest.com/pin/create/button/?url='.url()->current(),
        ];

        $data['seo'] = FrontSeo::forJob($job);

        return view('front_web.jobs.job_details', compact('job', 'url'))->with($data);
    }

    public function saveFavouriteJob(Request $request): JsonResponse
    {
        $input = $request->all();
        $favouriteJob = $this->jobRepository->storeFavouriteJobs($input);
        if ($favouriteJob) {
            return $this->sendResponse($favouriteJob, __('messages.flash.fav_job_added'));
        }

        return $this->sendResponse($favouriteJob, __('messages.flash.fav_job_removed'));
    }

    public function reportJobAbuse(Request $request): JsonResponse
    {
        $input = $request->all();
        $this->jobRepository->storeReportJobAbuse($input);

        return $this->sendSuccess(__('messages.flash.job_abuse_reported'));
    }

    public function emailJobToFriend(EmailJobToFriendRequest $request): JsonResponse
    {
        $input = $request->all();
        $this->jobRepository->emailJobToFriend($input);

        return $this->sendSuccess(__('messages.flash.job_emailed_to'));
    }
}
