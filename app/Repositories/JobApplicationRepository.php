<?php

namespace App\Repositories;

use App\Models\Candidate;
use App\Models\Job;
use App\Models\JobApplication;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class JobApplicationRepository
 */
class JobApplicationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'job_id',
        'resume_id',
        'expected_salary',
        'notes',
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
        return JobApplication::class;
    }

    /**
     * @return mixed
     */
    public function checkJobStatus(int $jobId, int $candidateId, int $status)
    {
        return JobApplication::where('job_id', $jobId)
            ->where('candidate_id', $candidateId)
            ->where('status', $status)
            ->exists();
    }

    /**
     * @return mixed
     */
    public function showApplyJobForm($jobId)
    {
        /** @var Candidate $candidate */
        $candidate = Candidate::findOrFail(Auth::user()->owner_id);

        /** @var Job $job */
        $job = Job::whereJobId($jobId)->with('company')->first();
        $data['isActive'] = ($job->status == Job::STATUS_OPEN) ? true : false;

        $jobRepo = app(JobRepository::class);
        $data['isApplied'] = $this->checkJobStatus($job->id, $candidate->id, JobApplication::STATUS_APPLIED);

        $data['resumes'] = [];
        $data['isJobDrafted'] = false;
        if (! $data['isApplied']) {
            // get candidate resumes
            $data['resumes'] = $candidate->getMedia('resumes')->pluck('custom_properties.title', 'id');
            $data['default_resume'] = $candidate->getMedia('resumes', ['is_default' => true])->first();
            if (isset($data['default_resume'])) {
                $data['default_resume'] = $data['default_resume']->id;
            }

            // check job is drafted or not
            $data['isJobDrafted'] = $this->checkJobStatus($job->id, $candidate->id, JobApplication::STATUS_DRAFT);

            if ($data['isJobDrafted']) {
                $data['draftJobDetails'] = $job->appliedJobs()->where('candidate_id', $candidate->id)->first();
            }
        }
        $data['job'] = $job;

        return $data;
    }

    public function store(array $input): bool
    {
        try {
            $input['candidate_id'] = Auth::user()->owner_id;

            $job = Job::findOrFail($input['job_id']);
            if ($job->status != Job::STATUS_OPEN) {
                throw new UnprocessableEntityHttpException('job is not active.');
            }

            /** @var JobApplication $jobApplication */
            $jobApplication = JobApplication::where('job_id', $input['job_id'])
                ->where('candidate_id', $input['candidate_id'])
                ->first();

            if ($jobApplication && $jobApplication->status == JobApplication::STATUS_APPLIED) {
                throw new UnprocessableEntityHttpException('You have already applied for this job.');
            }

            if ($jobApplication && $jobApplication->status == JobApplication::STATUS_DRAFT) {
                $jobApplication->delete();
            }

            $input['candidate_id'] = Auth::user()->owner_id;
            $input['expected_salary'] = removeCommaFromNumbers($input['expected_salary']);
            $input['status'] = $input['application_type'] == 'apply' ? JobApplication::STATUS_APPLIED : JobApplication::STATUS_DRAFT;

            $this->create($input);

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function downloadMedia(JobApplication $jobApplication): array
    {
        try {
            $documentMedia = Media::find($jobApplication->resume_id);
            if ($documentMedia == null) {
                $documentMedia = Media::where('model_id', $jobApplication->candidate_id)->where('collection_name',
                    'resumes')->latest()->first();
            }
            $disk = $documentMedia->disk ?: 'local';
            $documentPath = $documentMedia->getPathRelativeToRoot();
            $file = Storage::disk($disk)->get($documentPath);

            $headers = [
                'Content-Type' => $documentMedia->mime_type,
                'Content-Description' => 'File Transfer',
                'Content-Disposition' => "attachment; filename={$documentMedia->file_name}",
                'filename' => $documentMedia->file_name,
            ];

            return [$file, $headers];
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
