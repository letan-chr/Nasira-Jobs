<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFAQRequest;
use App\Http\Requests\UpdateFAQRequest;
use App\Models\FAQ;
use App\Repositories\FAQRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FAQController extends AppBaseController
{
    /** @var FAQRepository */
    private $FAQRepository;

    public function __construct(FAQRepository $FAQRepository)
    {
        $this->FAQRepository = $FAQRepository;
    }

    /**
     * Display a listing of the FAQ.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('faqs.index');
    }

    /**
     * Store a newly created FAQ in storage.
     */
    public function store(CreateFAQRequest $request): JsonResponse
    {
        $input = $request->all();
        $this->FAQRepository->create($input);

        return $this->sendSuccess(__('messages.flash.faqs_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQ $faq): JsonResponse
    {
        return $this->sendResponse($faq, 'FAQs Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified FAQ.
     */
    public function show(FAQ $faq): JsonResponse
    {
        return $this->sendResponse($faq, 'FAQs Retrieved Successfully.');
    }

    /**
     * Update the specified FAQ in storage.
     */
    public function update(UpdateFAQRequest $request, FAQ $faq): JsonResponse
    {
        $input = $request->all();
        $this->FAQRepository->update($input, $faq->id);

        return $this->sendSuccess(__('messages.flash.faqs_update'));
    }

    /**
     * Remove the specified FAQ from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(FAQ $faq): JsonResponse
    {
        $faq->delete();

        return $this->sendSuccess(__('messages.flash.faqs_delete'));
    }
}
