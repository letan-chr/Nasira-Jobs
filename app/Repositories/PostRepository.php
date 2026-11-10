<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class PostCategoryRepository
 */
class PostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Post::class;
    }

    public function store($input): bool
    {
        try {
            /** @var Post $post */
            $input['created_by'] = getLoggedInUserId();
            $blogInput = Arr::only($input, ['title', 'description', 'created_by', 'is_default']);
            $post = $this->create($blogInput);

            if (isset($input['image']) && ! empty($input['image'])) {
                $post->addMedia($input['image'])->toMediaCollection(Post::PATH, config('app.media_disc'));
            }
            //update blog assign Categories
            if (isset($input['blogCategories']) && ! empty($input['blogCategories'])) {
                $post->postAssignCategories()->sync($input['blogCategories']);
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    public function updateBlog($blog, $input): bool
    {
        try {
            /** @var Post $blog */
            $blog->update($input);

            if (isset($input['image']) && ! empty($input['image'])) {
                $blog->clearMediaCollection(Post::PATH);
                $blog->addMedia($input['image'])->toMediaCollection(Post::PATH, config('app.media_disc'));
            }
            //update blog assign Categories
            if (isset($input['blogCategories']) && ! empty($input['blogCategories'])) {
                $blog->postAssignCategories()->sync($input['blogCategories']);
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getBlogLists()
    {
        $data['blogs'] = Post::with([
            'media', 'postAssignCategories', 'user' => function ($query) {
                $query->without('media', 'country', 'state', 'city');
            },
        ])->withCount('comments')->orderByDesc('id')->paginate(10);
        $data['blogCategories'] = PostCategory::withCount('postAssignCategories')->tobase()->get();
        $data['popularBlogs'] = Post::with('media')->orderByDesc('created_at')->take(3)->get();
        if (count($data['blogs']) > 0) {
            $data['comments'] = PostComment::wherePostId($data['blogs'][0]->id)->get();
        }

        return $data;
    }

    /**
     * @return mixed
     */
    public function getBlogDetails($blog)
    {
        $data['blog'] = Post::with([
            'media', 'postAssignCategories', 'user' => function ($query) {
                $query->without(['media', 'country', 'state', 'city']);
            },
        ])->findOrFail($blog->id);
        $data['blogCategories'] = PostCategory::withCount('postAssignCategories')->get();
        $data['blogCategory'] = PostCategory::toBase()->pluck('name', 'id');
        $data['popularBlogs'] = Post::with('media')->whereNotIn('id',
            [$blog->id])->orderByDesc('created_at')->take(3)->get();

        $data['comments'] = PostComment::with('user')->wherePostId($blog->id)->orderBy('id', 'DESC')->get();
        $data['prevPost'] = Post::where('id', '>', $blog->id)->orderBy('id', 'asc')->first();
        $data['nextPost'] = Post::where('id', '<', $blog->id)->orderBy('id', 'desc')->first();

        return $data;
    }

    /**
     * @return mixed
     */
    public function getBlogDetailsByCategory(PostCategory $blogCategory)
    {
        $categoryId = $blogCategory->id;
        $data['blogs'] = Post::with(['postAssignCategories', 'user' => function ($query) {
            $query->without(['media', 'country', 'state', 'city']);
        }, 'media'])->withCount('comments')
            ->whereHas('postAssignCategories', function (Builder $q) use ($categoryId) {
                $q->where('post_categories_id', '=', $categoryId);
            })->paginate(10);
        $blogIds = $data['blogs']->pluck('id')->toArray();
        $data['blogCategories'] = PostCategory::withCount('postAssignCategories')->toBase()->get();
        $data['blogCategory'] = PostCategory::toBase()->pluck('name', 'id');
        $data['popularBlogs'] = Post::with('media')->whereNotIn('id',
            $blogIds)->orderByDesc('created_at')->take(3)->get();
        $data['categoryId'] = $categoryId;

        return $data;
    }

    /**
     * @return mixed
     */
    public function createComment($blogId, $input)
    {
        try {
            DB::beginTransaction();
            $comment = PostComment::create([
                'name' => Auth::check() ? getLoggedInUser()->full_name : $input['name'],
                'email' => Auth::check() ? getLoggedInUser()->email : $input['email'],
                'comment' => $input['comment'],
                'post_id' => $blogId,
                'user_id' => Auth::check() ? getLoggedInUserId() : null,
            ]);

            DB::commit();

            return $comment;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
