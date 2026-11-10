<?php

return [
    /*
    | Primary source of truth is Admin → Settings → Telegram.
    | Env values are fallbacks only.
    */
    'bot_token' => env('TELEGRAM_BOT_TOKEN'),
    'channel_id' => env('TELEGRAM_CHANNEL_ID', '@et_nasira'),
    'channel_name' => env('TELEGRAM_CHANNEL_NAME', 'Nasira Jobs'),
];
