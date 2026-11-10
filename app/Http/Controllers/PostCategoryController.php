<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostCategoryRequest;
use App\Http\Requests\UpdatePostCategoryRequest;
use App\Models\PostCategory;
use App\Repositories\PostCategoryRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostCategoryController extends AppBaseController
{
    /** @var PostCategoryRepository */
    private $postCategoryRepository;

    public function __construct(PostCategoryRepository $postCategoryRepository)
    {
        $this->postCategoryRepository = $postCategoryRepository;
    }

    /**
     * Display a listing of the BlogCategory.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        return view('blog_categories.index');
    }

    /**
     * Store a newly created BlogCategory in storage.
     */
    public function store(CreatePostCategoryRequest $request): JsonResponse
    {
        $input = $request->all();
        $this->postCategoryRepository->create($input);

        return $this->sendSuccess(__('messages.flash.post_category_save'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostCategory $postCategory): JsonResponse
    {
        return $this->sendResponse($postCategory, 'Post category Retrieved Successfully.');
    }

    /**
     * Show the form for editing the specified BlogCategory.
     */
    public function show(PostCategory $postCategory): JsonResponse
    {
        return $this->sendResponse($postCategory, __('messages.flash.post_category_retrieve'));
    }

    /**
     * Update the specified BlogCategory in storage.
     */
    public function update(UpdatePostCategoryRequest $request, PostCategory $postCategory): JsonResponse
    {
        $input = $request->all();

        $this->postCategoryRepository->update($input, $postCategory->id);

        return $this->sendSuccess(__('messages.flash.post_category_update'));
    }

    /**
     * Remove the specified BlogCategory from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(PostCategory $postCategory): JsonResponse
    {
        $postCategory->delete();

        return $this->sendSuccess(__('messages.flash.post_category_delete'));
    }
}
