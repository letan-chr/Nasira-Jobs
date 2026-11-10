<?php

namespace App\Services;

use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TelegramJobSyncService
{
    public function isConfigured(): bool
    {
        return filled($this->botToken()) && filled($this->channelId());
    }

    public function isEnabled(): bool
    {
        return (string) getSettingValue('telegram_enabled') === '1' && $this->isConfigured();
    }

    public function sync(Job $job): void
    {
        if (! $this->isEnabled()) {
            return;
        }

        if ($this->isLive($job)) {
            $job->telegram_message_id
                ? $this->edit($job)
                : $this->post($job);

            return;
        }

        if ($job->telegram_message_id) {
            $this->delete($job);
        }
    }

    public function remove(Job $job): void
    {
        if (! $this->isEnabled() || blank($job->telegram_message_id)) {
            return;
        }

        $this->delete($job);
    }

    /**
     * Remove a Telegram message after the Job model may already be deleted.
     */
    public function removeByIds(int $jobId, ?string $telegramMessageId): void
    {
        if (! $this->isEnabled() || blank($telegramMessageId)) {
            return;
        }

        $response = $this->api('deleteMessage', [
            'chat_id' => $this->channelId(),
            'message_id' => $telegramMessageId,
        ]);

        if (! ($response['ok'] ?? false)) {
            Log::warning('Telegram job delete failed', [
                'job_id' => $jobId,
                'telegram_message_id' => $telegramMessageId,
                'response' => $response,
            ]);
        }

        $stillThere = Job::query()->find($jobId);
        if ($stillThere) {
            $stillThere->updateQuietly(['telegram_message_id' => null]);
        }
    }

    /**
     * Normalize channel input from settings (t.me/et_nasira → @et_nasira).
     */
    public static function normalizeChannelId(?string $channel): ?string
    {
        if (! filled($channel)) {
            return null;
        }

        $channel = trim((string) $channel);
        $channel = preg_replace('#^(https?://)?(www\.)?t\.me/#i', '', $channel) ?? $channel;
        $channel = ltrim($channel, '/');

        if ($channel !== '' && $channel[0] !== '@' && ! preg_match('/^-?\d+$/', $channel)) {
            $channel = '@'.$channel;
        }

        return $channel !== '' ? $channel : null;
    }

    /**
     * Live API smoke test: send → edit → delete.
     *
     * @return array{ok: bool, message: string}
     */
    public function selfTest(): array
    {
        if (! $this->isConfigured()) {
            return ['ok' => false, 'message' => 'Save bot token and channel first.'];
        }

        $text = "Nasira Jobs Telegram test\n".now()->toDateTimeString();

        $sent = $this->api('sendMessage', [
            'chat_id' => $this->channelId(),
            'text' => $text,
        ]);

        if (! ($sent['ok'] ?? false)) {
            return [
                'ok' => false,
                'message' => 'Post failed: '.($sent['description'] ?? 'unknown error'),
            ];
        }

        $messageId = (string) data_get($sent, 'result.message_id');

        $edited = $this->api('editMessageText', [
            'chat_id' => $this->channelId(),
            'message_id' => $messageId,
            'text' => $text."\nUpdated OK",
        ]);

        if (! ($edited['ok'] ?? false)) {
            return [
                'ok' => false,
                'message' => 'Update failed: '.($edited['description'] ?? 'unknown error'),
            ];
        }

        $deleted = $this->api('deleteMessage', [
            'chat_id' => $this->channelId(),
            'message_id' => $messageId,
        ]);

        if (! ($deleted['ok'] ?? false)) {
            return [
                'ok' => false,
                'message' => 'Delete failed: '.($deleted['description'] ?? 'unknown error'),
            ];
        }

        return ['ok' => true, 'message' => 'Post, update, and delete all succeeded.'];
    }

    public function isLive(Job $job): bool
    {
        if ((int) $job->status !== Job::STATUS_OPEN || (int) $job->is_suspended === 1) {
            return false;
        }

        return blank($job->job_expiry_date) || $job->job_expiry_date >= now()->toDateString();
    }

    private function post(Job $job): void
    {
        $caption = $this->message($job);
        $logo = $this->resolveLogo($job);

        $response = $this->sendPhoto($logo, $caption);

        if (! ($response['ok'] ?? false)) {
            // Fallback to text-only if photo upload fails.
            $response = $this->api('sendMessage', [
                'chat_id' => $this->channelId(),
                'text' => $caption,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => false,
            ]);
        }

        if (! ($response['ok'] ?? false)) {
            $this->warn('post', $job, $response);

            return;
        }

        $id = (string) data_get($response, 'result.message_id');
        if ($id !== '') {
            $this->remember($job, $id);
        }
    }

    private function edit(Job $job): void
    {
        $caption = $this->message($job);

        // Prefer caption edit (photo posts). If it fails, delete + fresh photo post.
        $response = $this->api('editMessageCaption', [
            'chat_id' => $this->channelId(),
            'message_id' => $job->telegram_message_id,
            'caption' => $caption,
            'parse_mode' => 'HTML',
        ]);

        if ($response['ok'] ?? false) {
            return;
        }

        $error = Str::lower((string) data_get($response, 'description', ''));
        if (Str::contains($error, 'message is not modified')) {
            return;
        }

        // Old text posts / broken media: replace with a fresh photo post.
        $this->api('deleteMessage', [
            'chat_id' => $this->channelId(),
            'message_id' => $job->telegram_message_id,
        ]);
        $this->remember($job, null);
        $this->post($job->fresh() ?? $job);
    }

    private function delete(Job $job): void
    {
        $response = $this->api('deleteMessage', [
            'chat_id' => $this->channelId(),
            'message_id' => $job->telegram_message_id,
        ]);

        if (! ($response['ok'] ?? false)) {
            $this->warn('delete', $job, $response);
        }

        $this->remember($job, null);
    }

    private function remember(Job $job, ?string $messageId): void
    {
        $job->telegram_message_id = $messageId;

        if ($job->exists) {
            $job->updateQuietly(['telegram_message_id' => $messageId]);
        }
    }

    /**
     * Clean channel post (caption max ~1024 with photo).
     */
    private function message(Job $job): string
    {
        $job->loadMissing(['company.user', 'jobType', 'city', 'state', 'country', 'currency', 'salaryPeriod']);

        $company = $job->company?->user?->full_name ?: ($job->company?->ceo ?: 'Company');
        $location = collect([$job->city?->name, $job->state?->name, $job->country?->name])->filter()->implode(', ');
        $type = $job->jobType?->name ?? 'Job';
        $detailUrl = route('front.job.details', $job->job_id);
        $channelUrl = 'https://t.me/et_nasira';
        $deadline = $job->job_expiry_date
            ? $job->job_expiry_date->format('F j, Y')
            : 'Open';

        $salary = 'Hidden';
        if (! $job->hide_salary) {
            $currency = $job->currency?->currency_icon ?? $job->currency?->currency_code ?? '';
            $period = $job->salaryPeriod?->period;
            $salary = trim($currency.' '.$job->salary_from.' - '.$job->salary_to.($period ? ' / '.$period : ''));
        }

        $intro = trim(Str::limit(preg_replace('/\s+/', ' ', strip_tags((string) $job->description)) ?? '', 180));
        if ($intro === '') {
            $intro = $this->e($company).' would like to invite competent and qualified candidates.';
        } else {
            $intro = $this->e($intro);
        }

        $lines = [
            '★ <b>'.$this->e($company).' አዲስ የስራ ማስታወቂያ</b>',
            '',
            '♦ Deadline: '.$this->e($deadline),
            '',
            $intro,
            '',
            '✅ Position: '.$this->e((string) $job->job_title),
            '✅ Type: '.$this->e($type),
        ];

        if ($location !== '') {
            $lines[] = '✅ Location: '.$this->e($location);
        }

        $lines[] = '✅ Salary: '.$this->e($salary);
        $lines[] = '';
        $lines[] = '---';
        $lines[] = 'How to Apply Online?? 👇👇👇';
        $lines[] = $detailUrl;
        $lines[] = '🎈 Telegram:- '.$channelUrl;

        return Str::limit(implode("\n", $lines), 1024, '…');
    }

    /**
     * @return array{type: string, value: string}
     */
    private function resolveLogo(Job $job): array
    {
        $job->loadMissing(['company.user']);

        $media = $job->company?->user?->getMedia(User::PROFILE)->first();
        if ($media) {
            $path = $media->getPath();
            if (is_string($path) && is_file($path)) {
                return ['type' => 'file', 'value' => $path];
            }

            $url = $media->getFullUrl();
            if ($this->isPublicHttpUrl($url)) {
                return ['type' => 'url', 'value' => $url];
            }
        }

        $companyUrl = (string) ($job->company?->company_url ?? '');
        if ($this->isPublicHttpUrl($companyUrl) && ! Str::contains($companyUrl, ['nasira-placeholder', 'infyom-logo'])) {
            return ['type' => 'url', 'value' => $companyUrl];
        }

        $settingLogo = (string) (getSettingValue('logo') ?? '');
        if ($settingLogo !== '') {
            if ($this->isPublicHttpUrl($settingLogo)) {
                return ['type' => 'url', 'value' => $settingLogo];
            }

            $local = public_path(ltrim(parse_url($settingLogo, PHP_URL_PATH) ?: $settingLogo, '/'));
            if (is_file($local)) {
                return ['type' => 'file', 'value' => $local];
            }
        }

        foreach ([
            public_path('front_web/images/nasira-logo.png'),
            public_path('assets/img/nasira-placeholder.png'),
        ] as $fallback) {
            if (is_file($fallback)) {
                return ['type' => 'file', 'value' => $fallback];
            }
        }

        return ['type' => 'url', 'value' => asset('front_web/images/nasira-logo.png')];
    }

    private function isPublicHttpUrl(string $url): bool
    {
        if (! preg_match('#^https?://#i', $url)) {
            return false;
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        return $host !== '' && ! in_array($host, ['127.0.0.1', 'localhost', '::1'], true);
    }

    /**
     * @param  array{type: string, value: string}  $logo
     * @return array<string, mixed>
     */
    private function sendPhoto(array $logo, string $caption): array
    {
        try {
            if (($logo['type'] ?? '') === 'file' && is_file($logo['value'])) {
                return Http::timeout(30)
                    ->attach('photo', file_get_contents($logo['value']), basename($logo['value']))
                    ->post($this->url('sendPhoto'), [
                        'chat_id' => $this->channelId(),
                        'caption' => $caption,
                        'parse_mode' => 'HTML',
                    ])
                    ->json() ?? ['ok' => false, 'description' => 'Empty response'];
            }

            return $this->api('sendPhoto', [
                'chat_id' => $this->channelId(),
                'photo' => $logo['value'],
                'caption' => $caption,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Throwable $e) {
            Log::error('Telegram sendPhoto error', ['error' => $e->getMessage()]);

            return ['ok' => false, 'description' => $e->getMessage()];
        }
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private function api(string $method, array $payload): array
    {
        try {
            return Http::timeout(20)
                ->asForm()
                ->post($this->url($method), $payload)
                ->json() ?? ['ok' => false, 'description' => 'Empty response'];
        } catch (\Throwable $e) {
            Log::error('Telegram API error', ['method' => $method, 'error' => $e->getMessage()]);

            return ['ok' => false, 'description' => $e->getMessage()];
        }
    }

    private function url(string $method): string
    {
        return 'https://api.telegram.org/bot'.$this->botToken().'/'.$method;
    }

    private function botToken(): ?string
    {
        $token = getSettingValue('telegram_bot_token');

        return filled($token) ? (string) $token : (config('telegram.bot_token') ?: null);
    }

    private function channelId(): ?string
    {
        $channel = getSettingValue('telegram_channel_id');
        if (! filled($channel)) {
            $channel = config('telegram.channel_id');
        }

        return self::normalizeChannelId($channel ? (string) $channel : null);
    }

    /**
     * @param  array<string, mixed>  $response
     */
    private function warn(string $action, Job $job, array $response): void
    {
        Log::warning('Telegram job '.$action.' failed', [
            'job_id' => $job->id,
            'telegram_message_id' => $job->telegram_message_id,
            'response' => $response,
        ]);
    }

    private function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
