<?php

namespace App\Console\Commands;

use App\Services\TelegramJobSyncService;
use Illuminate\Console\Command;

class TelegramTestCommand extends Command
{
    protected $signature = 'telegram:test';

    protected $description = 'Test Telegram channel post, update, and delete';

    public function handle(TelegramJobSyncService $telegram): int
    {
        $this->info('Running Telegram self-test...');

        $result = $telegram->selfTest();

        if ($result['ok']) {
            $this->info($result['message']);

            return self::SUCCESS;
        }

        $this->error($result['message']);

        return self::FAILURE;
    }
}
