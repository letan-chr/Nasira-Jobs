<?php

namespace App\Repositories;

use App\Models\JobCategory;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class JobCategoryRepository
 */
class JobCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
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
        return JobCategory::class;
    }

    public function store($input): JobCategory
    {
        try {
            $input['is_featured'] = (isset($input['is_featured'])) ? 1 : 0;

            /** @var JobCategory $jobCategory */
            $jobCategory = $this->create($input);

            if (isset($input['customer_image']) && ! empty($input['customer_image'])) {
                $jobCategory->addMedia($input['customer_image'])->toMediaCollection(JobCategory::PATH,
                    config('app.media_disc'));
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return $jobCategory;
    }

    public function updateJobCategory($input, $id): bool
    {
        try {
            $input['is_featured'] = (isset($input['is_featured'])) ? 1 : 0;

            /** @var JobCategory $jobCategories */
            $jobCategories = $this->update($input, $id);

            if (! empty($input['customer_image'])) {
                $jobCategories->clearMediaCollection(JobCategory::PATH);
                $jobCategories->addMedia($input['customer_image'])->toMediaCollection(JobCategory::PATH,
                    config('app.media_disc'));
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }
}
