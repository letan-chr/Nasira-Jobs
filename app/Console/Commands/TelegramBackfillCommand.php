<?php

namespace App\Console\Commands;

use App\Jobs\SyncJobToTelegramJob;
use App\Models\Job;
use App\Services\TelegramJobSyncService;
use Illuminate\Console\Command;

class TelegramBackfillCommand extends Command
{
    protected $signature = 'telegram:backfill
                            {--sync : Run synchronously instead of queueing}
                            {--limit=0 : Max jobs to process (0 = all)}';

    protected $description = 'Post or update all currently live jobs on Telegram';

    public function handle(TelegramJobSyncService $telegram): int
    {
        if (! $telegram->isEnabled()) {
            $this->error('Telegram sync is disabled or not configured. Save settings first.');

            return self::FAILURE;
        }

        $query = Job::query()
            ->where('status', Job::STATUS_OPEN)
            ->where('is_suspended', 0)
            ->where(function ($q) {
                $q->whereNull('job_expiry_date')
                    ->orWhereDate('job_expiry_date', '>=', now()->toDateString());
            })
            ->orderBy('id');

        $limit = (int) $this->option('limit');
        if ($limit > 0) {
            $query->limit($limit);
        }

        $count = 0;
        $query->chunkById(50, function ($jobs) use ($telegram, &$count) {
            foreach ($jobs as $job) {
                if ($this->option('sync')) {
                    $telegram->sync($job);
                } else {
                    SyncJobToTelegramJob::dispatch($job->id, 'sync');
                }
                $count++;
            }
        });

        $mode = $this->option('sync') ? 'synced' : 'queued';
        $this->info("Telegram backfill {$mode} for {$count} live job(s).");

        return self::SUCCESS;
    }
}
