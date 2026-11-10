<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\Setting;
use App\Services\TelegramJobSyncService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TelegramJobSyncTest extends TestCase
{
    /** @var array<string, string|null> */
    private array $originalSettings = [];

    protected function setUp(): void
    {
        parent::setUp();

        foreach (['telegram_enabled', 'telegram_bot_token', 'telegram_channel_id'] as $key) {
            $this->originalSettings[$key] = Setting::where('key', $key)->value('value');
        }
    }

    protected function tearDown(): void
    {
        foreach ($this->originalSettings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        parent::tearDown();
    }

    public function test_skips_when_disabled(): void
    {
        $this->setTelegramSettings(enabled: false);
        Http::fake();

        $job = $this->fakeJob();
        app(TelegramJobSyncService::class)->sync($job);

        Http::assertNothingSent();
    }

    public function test_posts_updates_and_deletes_live_job(): void
    {
        $this->setTelegramSettings(enabled: true);

        Http::fake([
            'api.telegram.org/*' => Http::sequence()
                ->push(['ok' => true, 'result' => ['message_id' => 101]])
                ->push(['ok' => true, 'result' => ['message_id' => 101]])
                ->push(['ok' => true]),
        ]);

        $job = $this->fakeJob();
        $service = app(TelegramJobSyncService::class);

        $service->sync($job);
        $this->assertSame('101', (string) $job->telegram_message_id);

        $job->job_title = 'Nasira QA Engineer (Updated)';
        $service->sync($job);

        $job->status = Job::STATUS_CLOSED;
        $service->sync($job);
        $this->assertNull($job->telegram_message_id);

        Http::assertSentCount(3);
        Http::assertSent(fn ($request) => str_contains($request->url(), '/sendMessage'));
        Http::assertSent(fn ($request) => str_contains($request->url(), '/editMessageText'));
        Http::assertSent(fn ($request) => str_contains($request->url(), '/deleteMessage'));
    }

    public function test_self_test_roundtrip(): void
    {
        $this->setTelegramSettings(enabled: true);

        Http::fake([
            'api.telegram.org/*' => Http::sequence()
                ->push(['ok' => true, 'result' => ['message_id' => 55]])
                ->push(['ok' => true, 'result' => ['message_id' => 55]])
                ->push(['ok' => true]),
        ]);

        $result = app(TelegramJobSyncService::class)->selfTest();

        $this->assertTrue($result['ok']);
        $this->assertStringContainsString('succeeded', $result['message']);
        Http::assertSentCount(3);
    }

    private function setTelegramSettings(bool $enabled): void
    {
        Setting::updateOrCreate(['key' => 'telegram_enabled'], ['value' => $enabled ? '1' : '0']);
        Setting::updateOrCreate(['key' => 'telegram_bot_token'], ['value' => '999999:TEST_TOKEN']);
        Setting::updateOrCreate(['key' => 'telegram_channel_id'], ['value' => '@ethio_nasira_bot']);
    }

    private function fakeJob(): Job
    {
        $job = new Job([
            'job_title' => 'Nasira QA Engineer',
            'job_id' => 'tgtestjob001',
            'status' => Job::STATUS_OPEN,
            'is_suspended' => 0,
            'description' => '<p>Clean telegram sync test</p>',
            'salary_from' => 1000,
            'salary_to' => 2000,
            'hide_salary' => 0,
            'job_expiry_date' => now()->addDays(10)->toDateString(),
        ]);
        $job->id = 999001;
        $job->exists = false;

        return $job;
    }
}
