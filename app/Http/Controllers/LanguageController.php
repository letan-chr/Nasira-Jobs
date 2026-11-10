<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use App\Repositories\LanguageRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class LanguageController extends AppBaseController
{
    /** @var LanguageRepository */
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepo)
    {
        $this->languageRepository = $languageRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws \Exception
     */
    public function index(): View
    {
        return view('languages.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateLanguageRequest $request): JsonResponse
    {
        $input = $request->all();
        $language = $this->languageRepository->create($input);
        Artisan::call('lang:js');

        return $this->sendResponse($language, __('messages.flash.language_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language): JsonResponse
    {
        return $this->sendResponse($language, 'Language Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Language $language): JsonResponse
    {
        return $this->sendResponse($language, __('messages.flash.language_retrieve'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageRequest $request, Language $language): JsonResponse
    {
        $input = $request->all();
        $this->languageRepository->update($input, $language->id);
        Artisan::call('lang:js');

        return $this->sendSuccess(__('messages.flash.language_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @throws \Exception
     */
    public function destroy(Language $language): JsonResponse
    {
        $languageIds = $language->candidate()->pluck('language_id')->toArray();
        if (in_array($language->id, $languageIds)) {
            return $this->sendError(__('messages.language.language_cant_delete'));
        }

        $path = base_path('lang/').$language->iso_code;
        $language->delete();

        if (\File::exists($path)) {
            \File::deleteDirectory($path);
            $language->delete();
        } else {
            return $this->sendError(__('messages.language.language_not_deleted'));
        }

        Artisan::call('lang:js');

        return $this->sendSuccess(__('messages.flash.language_delete'));
    }
}
