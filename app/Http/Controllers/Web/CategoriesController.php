<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Repositories\WebHomeRepository;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    /** @var WebHomeRepository */
    private $homeRepository;

    public function __construct(WebHomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function index(): View
    {
        $jobCategories = $this->homeRepository->getAllJobCategories();

        return view('front_web.categories.index', compact('jobCategories'));
    }
}
