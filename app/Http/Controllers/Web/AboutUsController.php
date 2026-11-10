<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\CmsServices;
use App\Models\FAQ;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AboutUsController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function FAQLists(): View
    {
        $faqLists = FAQ::tobase()->get();
        $settings = CmsServices::pluck('value', 'key');

        return view('front_web.about_us.index', compact('faqLists', 'settings'));
    }
}
