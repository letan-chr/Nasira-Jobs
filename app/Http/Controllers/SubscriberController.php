<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\View\View;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\Factory;

/**
 * Class SubscriberController
 */
class SubscriberController extends AppBaseController
{
    /**
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('subscribers.index');
    }

    /**
     * Remove the specified NewsLetter from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(NewsLetter $newsLetter): JsonResponse
    {
        $newsLetter->delete();

        return $this->sendSuccess(__('messages.flash.newsletter_delete'));
    }
}
