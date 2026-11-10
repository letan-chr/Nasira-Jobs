<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoticeboardRequest;
use App\Http\Requests\UpdateNoticeboardRequest;
use App\Models\Noticeboard;
use App\Repositories\NoticeboardRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoticeboardController extends AppBaseController
{
    /** @var NoticeboardRepository */
    private $noticeboardRepository;

    public function __construct(NoticeboardRepository $noticeboardRepository)
    {
        $this->noticeboardRepository = $noticeboardRepository;
    }

    /**
     * Display a listing of the Noticeboard.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        $statusArr = Noticeboard::STATUS;
        $noticeboards = Noticeboard::toBase()->get();

        return view('noticeboards.index', compact('statusArr', 'noticeboards'));
    }

    /**
     * Store a newly created Noticeboard in storage.
     */
    public function store(CreateNoticeboardRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['is_active'] = (isset($input['is_active'])) ? 1 : 0;
        $this->noticeboardRepository->store($input);

        return $this->sendSuccess(__('messages.flash.noticeboard_save'));
//        return $this->sendSuccess('This functionality not allowed in demo.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Noticeboard $noticeboard): JsonResponse
    {
        return $this->sendResponse($noticeboard, __('messages.flash.noticeboard_retrieve'));
    }

    /**
     * Show the form for editing the specified Noticeboard.
     */
    public function show(Noticeboard $noticeboard): JsonResponse
    {
        return $this->sendResponse($noticeboard, __('messages.flash.noticeboard_retrieve'));
    }

    /**
     * Update the specified Noticeboard in storage.
     */
    public function update(UpdateNoticeboardRequest $request, Noticeboard $noticeboard): JsonResponse
    {
        $input = $request->all();
        $input['is_active'] = (isset($input['is_active'])) ? 1 : 0;
        $this->noticeboardRepository->update($input, $noticeboard->id);

        return $this->sendSuccess(__('messages.flash.noticeboard_update'));
    }

    /**
     * Remove the specified Noticeboard from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(Noticeboard $noticeboard): JsonResponse
    {
        $noticeboard->delete();

        return $this->sendSuccess(__('messages.flash.noticeboard_delete'));
    }

    public function changeStatus($id): JsonResponse
    {
        $notice = Noticeboard::findOrFail($id);
        $status = ! $notice->is_active;
        $notice->update(['is_active' => $status]);

        return $this->sendSuccess(__('messages.flash.status_update'));
    }
}
