<?php

namespace App\Observers;

use App\Jobs\SyncJobToTelegramJob;
use App\Models\Job;
use App\Services\TelegramJobSyncService;

class JobObserver
{
    public function created(Job $job): void
    {
        $this->queueSync($job);
    }

    public function updated(Job $job): void
    {
        $this->queueSync($job);
    }

    public function deleted(Job $job): void
    {
        if (! app(TelegramJobSyncService::class)->isEnabled()) {
            return;
        }

        if (blank($job->telegram_message_id)) {
            return;
        }

        SyncJobToTelegramJob::dispatch($job->id, 'remove', $job->telegram_message_id)->afterCommit();
    }

    private function queueSync(Job $job): void
    {
        if (! app(TelegramJobSyncService::class)->isEnabled()) {
            return;
        }

        SyncJobToTelegramJob::dispatch($job->id, 'sync')->afterCommit();
    }
}
