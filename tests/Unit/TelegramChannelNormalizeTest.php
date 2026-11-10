<?php

namespace Tests\Unit;

use App\Services\TelegramJobSyncService;
use PHPUnit\Framework\TestCase;

class TelegramChannelNormalizeTest extends TestCase
{
    public function test_normalizes_tme_links_and_usernames(): void
    {
        $this->assertSame('@et_nasira', TelegramJobSyncService::normalizeChannelId('t.me/et_nasira'));
        $this->assertSame('@et_nasira', TelegramJobSyncService::normalizeChannelId('https://t.me/et_nasira'));
        $this->assertSame('@et_nasira', TelegramJobSyncService::normalizeChannelId('et_nasira'));
        $this->assertSame('@et_nasira', TelegramJobSyncService::normalizeChannelId('@et_nasira'));
        $this->assertSame('-100123', TelegramJobSyncService::normalizeChannelId('-100123'));
    }
}
