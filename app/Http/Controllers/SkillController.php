<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use App\Repositories\SkillRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends AppBaseController
{
    /** @var SkillRepository */
    private $skillRepository;

    public function __construct(SkillRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
    }

    /**
     * Display a listing of the Skill.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('skills.index');
    }

    /**
     * Store a newly created Skill in storage.
     */
    public function store(CreateSkillRequest $request): JsonResponse
    {
        $input = $request->all();
        $skill = $this->skillRepository->create($input);

        return $this->sendResponse($skill, __('messages.flash.skill_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill): JsonResponse
    {
        return $this->sendResponse($skill, 'Skill Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified Skill.
     */
    public function show(Skill $skill): JsonResponse
    {
        return $this->sendResponse($skill, 'Skill Retrieved Successfully.');
    }

    /**
     * Update the specified Skill in storage.
     */
    public function update(UpdateSkillRequest $request, Skill $skill): JsonResponse
    {
        $input = $request->all();
        $this->skillRepository->update($input, $skill->id);

        return $this->sendSuccess(__('messages.flash.skill_update'));
    }

    /**
     * Remove the specified Skill from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(Skill $skill): JsonResponse
    {
        $candidateskillIds = $skill->candidate()->pluck('skill_id')->toArray();
        $jobskillIds = $skill->jobs()->pluck('skill_id')->toArray();
        if (in_array($skill->id, $candidateskillIds) || in_array($skill->id, $jobskillIds)) {
            return $this->sendError(__('messages.flash.skill_cant_delete'));
        } else {
            $skill->delete();
        }

        return $this->sendSuccess(__('messages.flash.skill_delete'));
    }
}
