<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Setting;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use App\Models\CmsServices;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\Factory;
use App\Repositories\WebHomeRepository;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ContactFormRequest;
use App\Http\Controllers\AppBaseController;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomeController extends AppBaseController
{
    /** @var WebHomeRepository */
    private $homeRepository;

    public function __construct(WebHomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index(): View
    {
        $data['testimonials'] = $this->homeRepository->getTestimonials();
        $data['dataCounts'] = $this->homeRepository->getDataCounts();
        $data['latestJobs'] = $this->homeRepository->getLatestJobs()->take(4);
        $data['categories'] = $this->homeRepository->getCategories();
        $data['jobCategories'] = $this->homeRepository->getAllJobCategories()->where('is_featured', 1)->take(8);
        $data['featuredCompanies'] = $this->homeRepository->getFeaturedCompanies();
        $data['allCompanies'] = $this->homeRepository->getAllCompanies();
        $data['featuredJobs'] = $this->homeRepository->getFeaturedJobs();
        $data['notices'] = $this->homeRepository->getNotices();
        [$data['imageSliders'], $data['settings'], $data['slider'], $data['imageSliderActive'], $data['headerSliders']] = $this->homeRepository->getImageSlider();
        $data['latestJobsEnable'] = $this->homeRepository->getLatestJobsEnable();
        $data['plans'] = $this->homeRepository->getPlans();
        $data['plansArray'] = array_chunk($data['plans']->toArray(), 3);
        $data['branding'] = $this->homeRepository->getBranding();
        $data['recentBlog'] = $this->homeRepository->getRecentBlog();
        $data['cmsServices'] = CmsServices::pluck('value', 'key')->toArray();
        $data['color'] = Setting::COLOR;
        $data['seo'] = \App\Support\FrontSeo::home();

        return view('front_web.home.home')->with($data);
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function sendContactEmail(ContactFormRequest $request): RedirectResponse
    {
        $inquiry = $this->homeRepository->storeInquires($request->all());
        Flash::success(__('messages.flash.thank_you_for_contacting_us'));

        return redirect(route('front.contact'));
    }

    public function changeLanguage(Request $request): JsonResponse
    {
        $language = $request->input('languageName');

        Session::put('languageName', $language);

        /** @var User $user */
        $user = getLoggedInUser();
        if(! empty($user)){
            $user->update(['language' => $language]);
        }
        return $this->sendSuccess(__('messages.flash.language_changed'));
    }

    /**
     * @return array|string
     *
     * @throws Throwable
     */
    public function getJobsSearch(Request $request)
    {
        $searchTerm = strtolower($request->get('searchTerm'));

        $results = $this->homeRepository->jobSearch($searchTerm);

        return response()->json(['results' => $results]);
    }
}
