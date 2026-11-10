<?php

namespace App\Jobs;

use App\Models\Job;
use App\Services\TelegramJobSyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncJobToTelegramJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 30;

    public function __construct(
        public int $jobId,
        public string $action = 'sync',
        public ?string $telegramMessageId = null,
    ) {}

    public function handle(TelegramJobSyncService $telegram): void
    {
        if ($this->action === 'remove') {
            $telegram->removeByIds($this->jobId, $this->telegramMessageId);

            return;
        }

        $job = Job::query()->find($this->jobId);
        if (! $job) {
            return;
        }

        $telegram->sync($job);
    }
}
