<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailToCandidate;
use App\Models\EmailTemplate;
use App\Models\JobType;
use App\Models\Job;
use App\Models\User;

class CandidatesAlertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobType = JobType::with('candidateJobAlerts')->whereId($this->data)->first();
        $job = Job::where('job_type_id', $jobType->id)->latest()->first();
        $userIds = $jobType->candidateJobAlerts->where('job_alert', '=', 1)->pluck('user_id');
        $users = User::whereIn('id', $userIds)->get();

        $templateBody = EmailTemplate::whereTemplateName('Job Alert')->first();
        foreach ($users as $user) {
            $job->name = $user->full_name;
            $keyVariable = ['{{job_name}}', '{{job_url}}', '{{job_title}}', '{{from_name}}'];
            $value = [$job->name, asset('/job-details/'.$job->job_id), $job->job_title, config('app.name')];
            $body = str_replace($keyVariable, $value, $templateBody->body);
            $data['body'] = $body;

            $data['data'] = $data;
            $data['email'] = $user->email;

            Mail::to($data['email'])->send(new EmailToCandidate($data));
            sleep(1);
        }
    }
}
