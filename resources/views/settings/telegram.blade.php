@extends('settings.index')
@section('title')
    Telegram
@endsection
@section('section')
    {{ Form::open(['route' => 'settings.update', 'id' => 'telegramSettingForm']) }}
    {{ Form::hidden('sectionName', $sectionName) }}

    <div class="row mt-3 mb-4">
        <div class="col-12">
            <p class="text-muted mb-0">
                When enabled, live jobs are posted to your Telegram channel (queued). Updates edit the same message; deletes remove it.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-6 mb-5">
            {{ Form::label('telegram_enabled', 'Enable Telegram job sync', ['class' => 'form-label d-inline']) }}
            <div class="form-check form-switch">
                <input class="form-check-input {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}"
                       name="telegram_enabled"
                       type="checkbox"
                       value="1"
                       {{ !empty($setting['telegram_enabled']) && $setting['telegram_enabled'] == '1' ? 'checked' : '' }}>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-5">
            {{ Form::label('telegram_bot_token', 'Bot token', ['class' => 'form-label']) }}
            <input type="password"
                   name="telegram_bot_token"
                   class="form-control"
                   value="{{ $setting['telegram_bot_token'] ?? '' }}"
                   placeholder="123456:ABC-DEF..."
                   autocomplete="new-password">
            <div class="form-text">From @BotFather. Leave blank to keep the current token.</div>
        </div>
        <div class="col-md-6 mb-5">
            {{ Form::label('telegram_channel_name', 'Channel name (display)', ['class' => 'form-label']) }}
            {{ Form::text('telegram_channel_name', $setting['telegram_channel_name'] ?? 'Nasira Jobs', [
                'class' => 'form-control',
                'placeholder' => 'Nasira Jobs',
            ]) }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-5">
            {{ Form::label('telegram_channel_id', 'Channel username or chat ID', ['class' => 'form-label']) }}
            {{ Form::text('telegram_channel_id', $setting['telegram_channel_id'] ?? '@et_nasira', [
                'class' => 'form-control',
                'placeholder' => '@et_nasira',
            ]) }}
            <div class="form-text">
                Add the bot as an <strong>admin</strong> of this channel.
                Accepts <code>@et_nasira</code>, <code>t.me/et_nasira</code>, or numeric chat id.
            </div>
        </div>
    </div>

    <div class="alert alert-light border">
        <strong>Setup</strong>
        <ol class="mb-0 ps-3">
            <li>Create a bot with <code>@BotFather</code> and paste the token above.</li>
            <li>Open channel <code>@et_nasira</code> (Nasira Jobs) and add the bot as administrator (Post Messages).</li>
            <li>Save settings, enable sync, then click <strong>Test Telegram</strong>.</li>
            <li>Optional: <code>php artisan telegram:backfill</code> to post existing live jobs.</li>
        </ol>
    </div>

    <div class="d-flex justify-content-end mb-5 mt-5 gap-2 flex-wrap">
        {{ Form::button(__('messages.common.save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
        <a href="{{ route('telegram.test') }}" class="btn btn-light-primary"
           onclick="return confirm('Run a live Telegram post → update → delete test now?');">
            Test Telegram
        </a>
        <a href="{{ route('settings.index', ['section' => 'telegram']) }}"
           class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
    </div>
    {{ Form::close() }}
@endsection
