<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use App\Repositories\JobNotificationRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class JobNotificationController extends AppBaseController
{
    /**
     * @var JobNotificationRepository
     */
    private $jobNotificationRepository;

    public function __construct(JobNotificationRepository $jobNotificationRepository)
    {
        $this->jobNotificationRepository = $jobNotificationRepository;
    }

    /**
     * @param  Request  $request
     * @return Application|Factory|JsonResponse|View
     */
    public function index(): View
    {
        $data = $this->jobNotificationRepository->getJobNotificationData();

        return view('job_notification.index')->with($data);
    }

    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();

        $jobNotification = $this->jobNotificationRepository->sendJobNotification($input);

        Flash::success(__('messages.flash.job_notification'));

        return redirect(route('job-notification.index'));
    }

    public function getEmployerJobs($id = null): JsonResponse
    {
        if (! empty($id)) {
            $employerJobs = Company::where('id', $id)->with([
                'user', 'jobs' => function (HasMany $query) {
                    $query->whereDate('job_expiry_date', '>=', Carbon::now()->toDateString())->where('status', '=', '1');
                },
            ])->first();
        } else {
            $employerJobs = Job::whereDate('job_expiry_date', '>=', Carbon::now()->toDateString())->where('status',
                '1')->where('is_suspended', Job::NOT_SUSPENDED)->orderBy('created_at',
                    'desc')->get();
        }

        return $this->sendResponse($employerJobs, 'Employer jobs retrieved successfully.');
    }
}
