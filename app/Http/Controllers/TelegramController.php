<?php

namespace App\Http\Controllers;

use App\Services\TelegramJobSyncService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class TelegramController extends AppBaseController
{
    public function test(TelegramJobSyncService $telegram): RedirectResponse
    {
        $result = $telegram->selfTest();

        if ($result['ok']) {
            Flash::success($result['message']);
        } else {
            Flash::error($result['message']);
        }

        return Redirect::route('settings.index', ['section' => 'telegram']);
    }
}
