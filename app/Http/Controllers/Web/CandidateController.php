<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\Candidate;
use App\Repositories\Candidates\CandidateRepository;
use App\Support\FrontSeo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateController extends AppBaseController
{
    /** @var CandidateRepository */
    private $candidateRepository;

    public function __construct(CandidateRepository $candidateRepo)
    {
        $this->candidateRepository = $candidateRepo;
    }

    /**
     * @return Application|Factory|View
     */
    public function getCandidateDetails($uniqueId): View
    {
        $candidate = Candidate::whereUniqueId($uniqueId)->first();
        $data = $this->candidateRepository->getCandidateDetail($candidate->id);
        $data['seo'] = FrontSeo::forCandidate($data['candidateDetails'] ?? $candidate);

        return view('front_web.candidate.candidate_details')->with($data);
    }

    /**
     * @return Application|Factory|View
     */
    public function getCandidatesLists(Request $request): View
    {
        return view('front_web.candidate.index', [
            'seo' => FrontSeo::candidatesIndex(),
        ]);
    }
}
