<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use App\Support\FrontSeo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends AppBaseController
{
    /** @var CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepository = $companyRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // redirect to jobs listing page
    }

    /**
     * @return Application|Factory|View
     */
    public function getCompaniesDetails($uniqueId): View
    {
        $company = Company::whereUniqueId($uniqueId)->first();

        $data = $this->companyRepository->getCompanyDetail($company->id);
        $data['seo'] = FrontSeo::forCompany($data['companyDetail'] ?? $company);

        return view('front_web.company.company_details')->with($data);
    }

    /**
     * @return Application|Factory|View
     */
    public function getCompaniesLists(Request $request): View
    {
        return view('front_web.company.index', [
            'seo' => FrontSeo::companiesIndex(),
        ]);
    }

    public function saveFavouriteCompany(Request $request): JsonResponse
    {
        $input = $request->all();
        $favouriteJob = $this->companyRepository->storeFavouriteJobs($input);
        if ($favouriteJob) {
            return $this->sendResponse($favouriteJob, __('messages.flash.follow_company_successfully'));
        }

        return $this->sendResponse($favouriteJob, __('messages.flash.unfollow_company'));
    }

    public function reportToCompany(Request $request): JsonResponse
    {
        $input = $request->all();
        $this->companyRepository->storeReportToCompany($input);

        return $this->sendSuccess(__('messages.flash.report_to_company'));
    }
}
